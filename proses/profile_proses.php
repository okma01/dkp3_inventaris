<?php
require_once __DIR__ . '/../config/auth.php';
dkp_require_login();

include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengguna  = $_SESSION['id_pengguna'];

    // Cek apakah username sudah digunakan user lain
    $cek_stmt = mysqli_prepare($koneksi, "SELECT id_pengguna FROM pengguna WHERE username = ? AND id_pengguna != ?");
    if ($cek_stmt) {
        $username = $_POST['username'];
        mysqli_stmt_bind_param($cek_stmt, "si", $username, $id_pengguna);
        mysqli_stmt_execute($cek_stmt);
        $cek_result = mysqli_stmt_get_result($cek_stmt);
        mysqli_stmt_close($cek_stmt);

        if (mysqli_num_rows($cek_result) > 0) {
            header("Location: ../pages/profile.php?pesan=gagal");
            exit;
        }
    }

    $nama_lengkap = trim($_POST['nama_lengkap']);
    $username     = trim($_POST['username']);
    $pw_baru      = $_POST['password_baru'];

    if (!empty($pw_baru)) {
        $password = password_hash($pw_baru, PASSWORD_DEFAULT);
        $query  = "UPDATE pengguna SET nama_lengkap = ?, username = ?, password = ? WHERE id_pengguna = ?";
        $stmt   = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $nama_lengkap, $username, $password, $id_pengguna);
    } else {
        $query  = "UPDATE pengguna SET nama_lengkap = ?, username = ? WHERE id_pengguna = ?";
        $stmt   = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $nama_lengkap, $username, $id_pengguna);
    }

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        // Update session agar perubahan langsung terlihat di sidebar
        $_SESSION['nama_admin'] = $nama_lengkap;
        header("Location: ../pages/profile.php?pesan=sukses");
        exit;
    } else {
        mysqli_stmt_close($stmt);
        header("Location: ../pages/profile.php?pesan=gagal");
        exit;
    }
}
?>
