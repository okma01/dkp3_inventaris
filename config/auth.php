<?php
// Panggil sebelum koneksi database, keluaran HTML, atau perubahan data.
function dkp_require_login(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = filter_var($_SESSION['id_pengguna'] ?? null, FILTER_VALIDATE_INT);
    if (($_SESSION['status'] ?? null) !== 'login' || $userId === false || $userId < 1) {
        $directory = basename(dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $prefix = in_array($directory, ['pages', 'proses'], true) ? '../' : '';
        header('Location: ' . $prefix . 'login.php?pesan=belum_login', true, 302);
        exit;
    }

    if (!in_array($_SESSION['level'] ?? null, ['admin', 'petugas', 'pimpinan'], true)) {
        dkp_deny_access();
    }
}

function dkp_require_roles(array $roles): void
{
    dkp_require_login();
    if (!in_array($_SESSION['level'], $roles, true)) {
        dkp_deny_access();
    }
}

function dkp_deny_access(): void
{
    http_response_code(403);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Akses ditolak. Akun Anda tidak memiliki izin untuk tindakan atau halaman ini.';
    exit;
}
