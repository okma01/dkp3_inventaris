<?php 
// Mengaktifkan session php
session_start();
 
// Menghubungkan dengan koneksi
include '../config/koneksi.php';
 
// Menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = $_POST['password'];
 
// Menyeleksi data admin dengan username yang sesuai
$data = mysqli_query($koneksi,"SELECT * FROM admin WHERE username='$username'");
 
// Menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);
 
if($cek > 0){
    $row = mysqli_fetch_assoc($data);
    
    // Verifikasi Password (karena di tahap 1 kita pakai Hash Password)
    // Jika kamu memasukkan password manual tanpa hash di database, gunakan if($password == $row['password'])
    
    // Tapi karena database query tahap 1 saya menggunakan password hash 'admin123', kita pakai ini:
    if(password_verify($password, $row['password'])){
        
        // Buat Session Login
        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $row['nama_lengkap'];
        $_SESSION['status'] = "login";
        
        // Redirect ke dashboard
        header("location:../index.php");
        
    } else {
        // Password salah
        header("location:../login.php?pesan=gagal");
    }
} else {
    // Username tidak ditemukan
    header("location:../login.php?pesan=gagal");
}
?>