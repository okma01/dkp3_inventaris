<?php 
session_start();
include '../config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$data = mysqli_query($koneksi,"SELECT * FROM admin WHERE username='$username'");
$cek = mysqli_num_rows($data);

if($cek > 0){
    $row = mysqli_fetch_assoc($data);

    if(password_verify($password, $row['password'])){
        
        // SESSION YANG DIPAKAI DASHBOARD
        $_SESSION['id_admin']   = $row['id_admin'];
        $_SESSION['username']   = $row['username'];
        $_SESSION['nama_admin'] = $row['nama_lengkap'];
        $_SESSION['nip']        = $row['nip'];
        $_SESSION['status']     = "login";

        header("location:../index.php");
        exit;
    } else {
        header("location:../login.php?pesan=gagal");
        exit;
    }
} else {
    header("location:../login.php?pesan=gagal");
    exit;
}
?>
