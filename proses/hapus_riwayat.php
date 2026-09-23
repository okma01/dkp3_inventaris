<?php
require_once __DIR__ . '/../config/auth.php';
dkp_require_roles(['admin']);

include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM riwayat_barang WHERE id_riwayat='$id'";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: ../pages/riwayat.php");
    } else {
        echo "Gagal menghapus: " . mysqli_error($koneksi);
    }
} else {
    header("Location: ../pages/riwayat.php");
}
?>
