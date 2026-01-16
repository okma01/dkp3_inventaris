<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['simpan_keluar'])) {
    $id_barang = $_POST['id_barang'];
    $tanggal   = $_POST['tanggal'];
    $jumlah    = $_POST['jumlah'];
    $penerima  = $_POST['penerima'];
    $ket       = $_POST['keterangan'];

    // 1. Cek stok yang tersedia sekarang
    $cek_stok = mysqli_query($koneksi, "SELECT stok, nama_barang FROM barang WHERE id_barang = '$id_barang'");
    $data_stok = mysqli_fetch_assoc($cek_stok);
    $stok_saat_ini = $data_stok['stok'];

    if ($jumlah > $stok_saat_ini) {
        echo "<script>
                alert('Stok tidak cukup! Sisa stok hanya: $stok_saat_ini');
                window.location='barang_keluar.php';
              </script>";
        exit;
    }

    // 2. Insert ke barang_keluar
    $query_keluar = "INSERT INTO barang_keluar (id_barang, tanggal, jumlah, penerima, keterangan) 
                     VALUES ('$id_barang', '$tanggal', '$jumlah', '$penerima', '$ket')";
    
    // 3. Kurangi Stok
    $query_stok = "UPDATE barang SET stok = stok - $jumlah WHERE id_barang = '$id_barang'";

    if (mysqli_query($koneksi, $query_keluar) && mysqli_query($koneksi, $query_stok)) {
        // 4. Catat ke riwayat_barang
        $nama_user = isset($_SESSION['nama_admin']) ? $_SESSION['nama_admin'] : null;
        $nip_user  = isset($_SESSION['nip']) ? $_SESSION['nip'] : null;
        $nama_barang_log = isset($data_stok['nama_barang']) ? mysqli_real_escape_string($koneksi, $data_stok['nama_barang']) : '';

        mysqli_query($koneksi, "INSERT INTO riwayat_barang (nama_user, nip, nama_barang, jenis_aktivitas, jumlah, tanggal) 
                                 VALUES ('$nama_user', '$nip_user', '$nama_barang_log', 'keluar', $jumlah, '$tanggal')");

        header("location:../pages/barang_keluar.php");
        exit;
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>