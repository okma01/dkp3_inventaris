<?php
include '../config/koneksi.php';

if (isset($_POST['simpan_masuk'])) {
    $id_barang = $_POST['id_barang'];
    $tanggal   = $_POST['tanggal'];
    $jumlah    = $_POST['jumlah'];
    $ket       = $_POST['keterangan'];

    // 1. Masukkan ke riwayat barang_masuk
    $query_masuk = "INSERT INTO barang_masuk (id_barang, tanggal, jumlah, keterangan) 
                    VALUES ('$id_barang', '$tanggal', '$jumlah', '$ket')";
    
    // 2. Update stok di tabel barang (Stok Lama + Jumlah Masuk)
    $query_stok  = "UPDATE barang SET stok = stok + $jumlah WHERE id_barang = '$id_barang'";

    if (mysqli_query($koneksi, $query_masuk) && mysqli_query($koneksi, $query_stok)) {
        header("location:../pages/barang_masuk.php");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>