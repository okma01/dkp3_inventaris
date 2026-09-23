<?php
// Jalankan: php -n tests/auth_access_test.php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$root = dirname(__DIR__);
$checks = 0;
$failures = [];

function check_access(bool $condition, string $label): void
{
    global $checks, $failures;
    $checks++;
    if (!$condition) {
        $failures[] = $label;
    }
}

// Pastikan endpoint memanggil guard sebelum koneksi/HTML/aksi lainnya.
$routes = [
    'layout/header.php' => 'dkp_require_login();',
    'pages/tambah_pengguna.php' => "dkp_require_roles(['admin']);",
    'pages/daftar_pengguna.php' => "dkp_require_roles(['admin']);",
    'pages/edit_data_barang.php' => "dkp_require_roles(['admin', 'petugas']);",
    'pages/riwayat.php' => "dkp_require_roles(['admin', 'petugas']);",
    'pages/cetak.php' => 'dkp_require_login();',
    'pages/cetak_riwayat.php' => "dkp_require_roles(['admin', 'petugas']);",
    'proses/hapus_pengguna.php' => "dkp_require_roles(['admin']);",
    'proses/hapus_riwayat.php' => "dkp_require_roles(['admin']);",
    'proses/proses_barang.php' => "dkp_require_roles(['admin', 'petugas']);",
    'proses/edit_barang.php' => "dkp_require_roles(['admin', 'petugas']);",
    'proses/hapus_barang.php' => "dkp_require_roles(['admin', 'petugas']);",
    'proses/proses_masuk.php' => "dkp_require_roles(['admin', 'petugas']);",
    'proses/proses_keluar.php' => "dkp_require_roles(['admin', 'petugas']);",
    'proses/hapus_keluar.php' => "dkp_require_roles(['admin', 'petugas']);",
    'proses/profile_proses.php' => 'dkp_require_login();',
];
foreach ($routes as $route => $call) {
    $source = file_get_contents($root . '/' . $route);
    $prefix = "<?php\nrequire_once __DIR__ . '/../config/auth.php';\n" . $call;
    check_access(strpos(str_replace("\r\n", "\n", $source), $prefix) === 0, 'Guard first: ' . $route);
}

// Sesi buatan hanya hidup pada proses PHP CLI terpisah; tidak menyentuh database.
$states = [
    'guest' => [],
    'expired' => ['status' => 'logout', 'id_pengguna' => 1, 'level' => 'admin'],
    'missing-id' => ['status' => 'login', 'level' => 'admin'],
    'invalid-id' => ['status' => 'login', 'id_pengguna' => 0, 'level' => 'admin'],
    'unknown-role' => ['status' => 'login', 'id_pengguna' => 1, 'level' => 'owner'],
    'missing-role' => ['status' => 'login', 'id_pengguna' => 1],
    'admin' => ['status' => 'login', 'id_pengguna' => 1, 'level' => 'admin'],
    'petugas' => ['status' => 'login', 'id_pengguna' => 1, 'level' => 'petugas'],
    'pimpinan' => ['status' => 'login', 'id_pengguna' => 1, 'level' => 'pimpinan'],
];
$policies = [
    'read' => ['call' => 'dkp_require_login();', 'roles' => ['admin', 'petugas', 'pimpinan']],
    'manage-users' => ['call' => "dkp_require_roles(['admin']);", 'roles' => ['admin']],
    'manage-stock' => ['call' => "dkp_require_roles(['admin', 'petugas']);", 'roles' => ['admin', 'petugas']],
    'deny-all' => ['call' => 'dkp_require_roles([]);', 'roles' => []],
];

foreach ($states as $stateName => $state) {
    foreach ($policies as $policyName => $policy) {
        $code = 'session_start(["use_cookies" => false, "cache_limiter" => ""]);'
            . '$_SESSION = ' . var_export($state, true) . ';'
            . '$_SERVER["SCRIPT_NAME"] = "/dkp3_inventaris/proses/proses_barang.php";'
            . '$reached = false;'
            . 'register_shutdown_function(function () use (&$reached) {'
            . 'session_destroy();'
            . 'echo "#AUTH_TEST#" . json_encode(["reached" => $reached, "status" => http_response_code() ?: 200]);'
            . '});'
            . 'require ' . var_export($root . '/config/auth.php', true) . ';'
            . $policy['call']
            . '$reached = true;';
        $process = proc_open([PHP_BINARY, '-n', '-r', $code], [
            0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w'],
        ], $pipes);
        if (!is_resource($process)) {
            check_access(false, 'Could not start probe');
            continue;
        }
        fclose($pipes[0]);
        $output = stream_get_contents($pipes[1]);
        $errors = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);
        $marker = strrpos($output, '#AUTH_TEST#');
        $result = $marker === false ? null : json_decode(substr($output, $marker + 11), true);
        $authenticated = in_array($stateName, ['admin', 'petugas', 'pimpinan', 'unknown-role', 'missing-role'], true);
        $allowed = $authenticated && in_array($state['level'] ?? null, $policy['roles'], true);
        $expectedStatus = !$authenticated ? 302 : ($allowed ? 200 : 403);
        check_access(
            $exitCode === 0 && $errors === '' && $result !== null
                && $result['reached'] === $allowed && $result['status'] === $expectedStatus,
            $stateName . ' / ' . $policyName . ' expected ' . $expectedStatus . ': ' . $output . $errors
        );
    }
}

if ($failures) {
    fwrite(STDERR, implode(PHP_EOL, $failures) . PHP_EOL);
    exit(1);
}
echo $checks . " authorization checks passed." . PHP_EOL;
