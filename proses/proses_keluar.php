<?php
include '../config/koneksi.php';

if (isset($_POST['simpan_keluar'])) {
    $id_barang = $_POST['id_barang'];
    $tanggal   = $_POST['tanggal'];
    $jumlah    = $_POST['jumlah'];
    $penerima  = $_POST['penerima'];
    $ket       = $_POST['keterangan'];

    // 1. Cek dulu stok yang tersedia sekarang
    $cek_stok = mysqli_query($koneksi, "SELECT stok FROM barang WHERE id_barang = '$id_barang'");
    $data_stok = mysqli_fetch_assoc($cek_stok);
    $stok_saat_ini = $data_stok['stok'];

    // 2. Jika permintaan melebihi stok, tolak
    if ($jumlah > $stok_saat_ini) {
        echo "<script>
                alert('Stok tidak cukup! Sisa stok hanya: $stok_saat_ini');
                window.location='barang_keluar.php';
              </script>";
        exit; // Berhenti di sini
    }

    // 3. Jika cukup, Insert ke riwayat
    $query_keluar = "INSERT INTO barang_keluar (id_barang, tanggal, jumlah, penerima, keterangan) 
                     VALUES ('$id_barang', '$tanggal', '$jumlah', '$penerima', '$ket')";
    
    // 4. Kurangi Stok
    $query_stok = "UPDATE barang SET stok = stok - $jumlah WHERE id_barang = '$id_barang'";

    if (mysqli_query($koneksi, $query_keluar) && mysqli_query($koneksi, $query_stok)) {
        header("location:../pages/barang_keluar.php");
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>