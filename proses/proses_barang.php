<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['id_kategori'];
    $satuan = $_POST['satuan'];
    $stok = $_POST['stok'];

    // LOGIKA UPLOAD FOTO
    $nama_foto = null; // Default kosong

    if (!empty($_FILES['foto']['name'])) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp  = $_FILES['foto']['tmp_name'];
        $ekstensi  = pathinfo($foto_name, PATHINFO_EXTENSION);

        $nama_foto_baru = 'barang_' . uniqid() . '.' . $ekstensi;
        $folder_tujuan  = '../assets/img_barang/' . $nama_foto_baru;

        if(move_uploaded_file($foto_tmp, $folder_tujuan)){
            $nama_foto = $nama_foto_baru;
        }
    }

    $query = "INSERT INTO barang (id_kategori, nama_barang, satuan, stok, foto) 
              VALUES ('$kategori', '$nama', '$satuan', '$stok', '$nama_foto')";
    
    if (mysqli_query($koneksi, $query)) {
        // Catat riwayat jika stok awal > 0 sebagai barang masuk
        if ((int)$stok > 0) {
            $nama_user = isset($_SESSION['nama_admin']) ? $_SESSION['nama_admin'] : null;
            $nip_user  = isset($_SESSION['nip']) ? $_SESSION['nip'] : null;
            $nama_barang_log = mysqli_real_escape_string($koneksi, $nama);
            $today = date('Y-m-d');
            mysqli_query($koneksi, "INSERT INTO riwayat_barang (nama_user, nip, nama_barang, jenis_aktivitas, jumlah, tanggal) 
                                     VALUES ('$nama_user', '$nip_user', '$nama_barang_log', 'masuk', $stok, '$today')");
        }

        echo "<script>alert('Data Berhasil Disimpan'); window.location='../pages/barang.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>