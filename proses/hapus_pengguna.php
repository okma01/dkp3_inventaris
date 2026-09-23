<?php
require_once __DIR__ . '/../config/auth.php';
dkp_require_roles(['admin']);

include '../config/koneksi.php';

if (isset($_GET['id'])) {
    
    $id = $_GET['id'];

    // Ambil nama pengguna sebelum dihapus (untuk dicatat di riwayat)
    $get_nama = mysqli_query($koneksi, "SELECT nama_lengkap FROM pengguna WHERE id_pengguna='$id'");
    $data_pengguna = mysqli_fetch_assoc($get_nama);
    $nama_pengguna_dihapus = $data_pengguna ? mysqli_real_escape_string($koneksi, $data_pengguna['nama_lengkap']) : 'Tidak diketahui';

    $hapus = mysqli_query($koneksi, "DELETE FROM pengguna WHERE id_pengguna='$id'");

    if ($hapus) {
        // Catat ke riwayat: siapa (admin) menghapus pengguna siapa
        $nama_admin = isset($_SESSION['nama_admin']) ? mysqli_real_escape_string($koneksi, $_SESSION['nama_admin']) : '';
        $nip_admin  = isset($_SESSION['nip']) ? mysqli_real_escape_string($koneksi, $_SESSION['nip']) : '';
        $today = date('Y-m-d H:i:s');

        mysqli_query($koneksi, "INSERT INTO riwayat_barang (nama_user, nip, nama_barang, jenis_aktivitas, jumlah, tanggal) 
                                 VALUES ('$nama_admin', '$nip_admin', '$nama_pengguna_dihapus', 'hapus_pengguna', 1, '$today')");

        header("Location: ../pages/daftar_pengguna.php"); 
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }

} else {
    header("Location: ../pages/daftar_pengguna.php");
}
?>
