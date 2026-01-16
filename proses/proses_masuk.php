<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['simpan_masuk'])) {
    $id_barang = $_POST['id_barang'];
    $tanggal   = $_POST['tanggal'];
    $jumlah    = $_POST['jumlah'];
    $ket       = $_POST['keterangan'];

    // 1. Masukkan ke tabel barang_masuk
    $query_masuk = "INSERT INTO barang_masuk (id_barang, tanggal, jumlah, keterangan) 
                    VALUES ('$id_barang', '$tanggal', '$jumlah', '$ket')";
    
    // 2. Update stok di tabel barang (Stok Lama + Jumlah Masuk)
    $query_stok  = "UPDATE barang SET stok = stok + $jumlah WHERE id_barang = '$id_barang'";

    if (mysqli_query($koneksi, $query_masuk) && mysqli_query($koneksi, $query_stok)) {
        // 3. Catat ke tabel riwayat_barang
        $nama_user = isset($_SESSION['nama_admin']) ? $_SESSION['nama_admin'] : null;
        $nip_user  = isset($_SESSION['nip']) ? $_SESSION['nip'] : null;

        $resNama = mysqli_query($koneksi, "SELECT nama_barang FROM barang WHERE id_barang='$id_barang'");
        $rowNama = $resNama ? mysqli_fetch_assoc($resNama) : null;
        $nama_barang_log = $rowNama ? $rowNama['nama_barang'] : '';
        $nama_barang_log = mysqli_real_escape_string($koneksi, $nama_barang_log);

        mysqli_query($koneksi, "INSERT INTO riwayat_barang (nama_user, nip, nama_barang, jenis_aktivitas, jumlah, tanggal) 
                                 VALUES ('$nama_user', '$nip_user', '$nama_barang_log', 'masuk', $jumlah, '$tanggal')");

        header("location:../pages/barang_masuk.php");
        exit;
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>