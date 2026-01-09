<?php
include '../config/koneksi.php';

$id = $_GET['id'];
$foto = $_GET['foto']; // Ambil nama foto dari parameter URL

// 1. Hapus file fisik di folder assets/img_barang jika ada
if($foto != "" && file_exists("../assets/img_barang/" . $foto)){
    unlink("../assets/img_barang/" . $foto);
}

// 2. Hapus data di database
mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang = '$id'");

header("location:../pages/barang.php");
?>