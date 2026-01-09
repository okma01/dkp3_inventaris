<?php
include '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['id_kategori'];
    $satuan = $_POST['satuan'];
    $stok = $_POST['stok'];

    // LOGIKA UPLOAD FOTO
    $nama_foto = null; // Default kosong

    // Cek apakah user mengupload foto
    if ($_FILES['foto']['name'] != "") {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp  = $_FILES['foto']['tmp_name'];
        $ekstensi  = pathinfo($foto_name, PATHINFO_EXTENSION);
        
        // Buat nama file unik (misal: barang_65a123.jpg) supaya tidak tertukar
        $nama_foto_baru = 'barang_' . uniqid() . '.' . $ekstensi;
        $folder_tujuan  = '../assets/img_barang/' . $nama_foto_baru;

        // Pindahkan file
        if(move_uploaded_file($foto_tmp, $folder_tujuan)){
            $nama_foto = $nama_foto_baru;
        }
    }

    $query = "INSERT INTO barang (id_kategori, nama_barang, satuan, stok, foto) 
              VALUES ('$kategori', '$nama', '$satuan', '$stok', '$nama_foto')";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data Berhasil Disimpan'); window.location='../pages/barang.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>