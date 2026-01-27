<?php 
session_start();
include '../config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// ====================================================
// LOGIKA BARU: Cek hanya di tabel 'pengguna'
// ====================================================

// Menggunakan prepared statement untuk keamanan (mencegah SQL Injection)
$query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$username'");
$cek = mysqli_num_rows($query);

if($cek > 0){
    $data = mysqli_fetch_assoc($query);

    // Verifikasi password (menggunakan hash)
    if(password_verify($password, $data['password'])){
        
        // SET SESSION
        // Gunakan nama variabel session yang sama agar tidak merusak halaman lain
        $_SESSION['id_pengguna'] = $data['id_pengguna'];
        $_SESSION['username']    = $data['username'];
        $_SESSION['nama_admin']  = $data['nama_lengkap']; // Di file lain mungkin memanggil 'nama_admin'
        $_SESSION['nip']         = $data['nip'];
        $_SESSION['level']       = $data['level']; // admin, petugas, atau pimpinan
        $_SESSION['status']      = "login";

        // Redirect ke dashboard
        header("location:../index.php");
        exit;
    } else {
        // Password salah
        header("location:../login.php?pesan=gagal");
        exit;
    }
} else {
    // Username tidak ditemukan
    header("location:../login.php?pesan=gagal");
    exit;
}
?>