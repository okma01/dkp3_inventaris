<?php
require_once __DIR__ . '/../config/auth.php';
dkp_require_roles(['admin', 'petugas']);

include '../config/koneksi.php';

if (isset($_GET['id']) && isset($_GET['idb']) && isset($_GET['qty'])) {
    $id_keluar = $_GET['id'];
    $id_barang = $_GET['idb'];
    $jumlah    = $_GET['qty'];

    // 1. Hapus data dari tabel barang_keluar
    $hapus = mysqli_query($koneksi, "DELETE FROM barang_keluar WHERE id_keluar = '$id_keluar'");

    // 2. Kembalikan stok barang (stok + jumlah yang dihapus)
    if ($hapus) {
        mysqli_query($koneksi, "UPDATE barang SET stok = stok + $jumlah WHERE id_barang = '$id_barang'");
    }

    header("location:../pages/barang_keluar.php");
    exit;
} else {
    header("location:../pages/barang_keluar.php");
    exit;
}
?>
