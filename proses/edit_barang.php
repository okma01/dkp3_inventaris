<?php
require_once __DIR__ . '/../config/auth.php';
dkp_require_roles(['admin', 'petugas']);

include '../config/koneksi.php';

if (isset($_POST['update_barang'])) {
    $id_barang  = $_POST['id_barang'];
    $nama       = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $kategori   = $_POST['id_kategori'];
    $satuan     = mysqli_real_escape_string($koneksi, $_POST['satuan']);
    $stok       = (int)$_POST['stok'];
    $foto_lama  = $_POST['foto_lama'];

    // Cek duplikat nama barang (kecuali barang ini sendiri)
    $cek_duplikat = mysqli_query($koneksi, "SELECT id_barang FROM barang WHERE LOWER(nama_barang) = LOWER('$nama') AND id_barang != '$id_barang'");
    if (mysqli_num_rows($cek_duplikat) > 0) {
        echo "<script>alert('Gagal! Barang dengan nama tersebut sudah ada di database.'); window.location='../pages/edit_data_barang.php?id=$id_barang';</script>";
        exit;
    }

    // Cek apakah ada foto baru yang diupload
    $nama_foto = $foto_lama; // Default: pakai foto lama

    if (!empty($_FILES['foto']['name'])) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp  = $_FILES['foto']['tmp_name'];
        $ekstensi  = pathinfo($foto_name, PATHINFO_EXTENSION);

        $nama_foto_baru = 'barang_' . uniqid() . '.' . $ekstensi;
        $folder_tujuan  = '../assets/img_barang/' . $nama_foto_baru;

        if (move_uploaded_file($foto_tmp, $folder_tujuan)) {
            // Hapus foto lama jika ada dan bukan default
            if ($foto_lama && file_exists('../assets/img_barang/' . $foto_lama)) {
                unlink('../assets/img_barang/' . $foto_lama);
            }
            $nama_foto = $nama_foto_baru;
        }
    }

    $query = "UPDATE barang SET 
              id_kategori = '$kategori', 
              nama_barang = '$nama', 
              satuan = '$satuan', 
              stok = '$stok', 
              foto = '$nama_foto' 
              WHERE id_barang = '$id_barang'";

    if (mysqli_query($koneksi, $query)) {
        header("location:../pages/edit_data_barang.php?id=$id_barang&pesan=sukses");
        exit;
    } else {
        header("location:../pages/edit_data_barang.php?id=$id_barang&pesan=gagal");
        exit;
    }
}
?>
