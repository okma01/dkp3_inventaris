<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_admin     = $_SESSION['id_admin'];
    // Ambil data dari form dengan nama yang benar
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pw_baru      = $_POST['password_baru'];

    if (!empty($pw_baru)) {
        // Jika ganti password (menggunakan password_hash lebih aman, 
        // tapi jika sistem Anda pakai MD5, ganti menjadi md5($pw_baru))
        $password = password_hash($pw_baru, PASSWORD_DEFAULT); 
        $query = "UPDATE admin SET 
                  nama_lengkap = '$nama_lengkap', 
                  username = '$username', 
                  password = '$password' 
                  WHERE id_admin = '$id_admin'";
    } else {
        // Jika tidak ganti password
        $query = "UPDATE admin SET 
                  nama_lengkap = '$nama_lengkap', 
                  username = '$username' 
                  WHERE id_admin = '$id_admin'";
    }

    if (mysqli_query($koneksi, $query)) {
        // Update session agar perubahan langsung terlihat di sidebar
        $_SESSION['nama_admin'] = $nama_lengkap; 
        header("Location: ../pages/profile.php?pesan=sukses");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>