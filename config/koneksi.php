<?php
$host = "localhost";
$user = "root";     // Default user Laragon
$pass = "";         // Default password Laragon kosong
$db   = "dkp3_inventaris";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

$base_url = "http://localhost/dkp3_inventaris/";
?>