<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../library/fpdf.php';

class PDF extends FPDF {
    // Setting Header (Kop Surat disamakan dengan cetak.php)
    function Header() {
        // Logo
        if (file_exists('../assets/logo.png')) {
            $this->Image('../assets/logo.png', 10, 6, 23); 
        }

        $this->SetFont('Times', 'B', 13);
        $this->SetX(34);
        $this->Cell(0, 6, 'PEMERINTAH KOTA BANJARBARU', 0, 1, 'C');

        $this->SetFont('Times', 'B', 15);
        $this->SetX(34);
        $this->Cell(0, 6, 'DINAS KETAHANAN PANGAN, PERTANIAN DAN PERIKANAN', 0, 1, 'C');

        $this->SetFont('Times', '', 10);
        $this->SetX(34);
        $this->Cell(0, 5, 'Alamat : Jl. Agus Salim, Banjarbaru Telp/ Fax. (0511) 4781050', 0, 1, 'C');

        $this->SetX(34);
        $this->Cell(0, 5, 'Website : www.dkp3.banjarbarukota.go.id   E-mail : dkp3@banjarbarukota.go.id', 0, 1, 'C');

        $this->Ln(4);
        $this->SetLineWidth(1);
        $this->Line(10, 36, 287, 36); // Panjang garis disesuaikan ke 287 karena Landscape (A4)
        $this->SetLineWidth(0);
        $this->Line(10, 37, 287, 37); 

        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' - Dicetak pada: ' . date('d-m-Y H:i'), 0, 0, 'C');
    }
}

// Menggunakan 'L' (Landscape) agar tabel riwayat yang lebar tidak terpotong
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

// Judul Laporan
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'RIWAYAT AKTIVITAS BARANG (LOG)', 0, 1, 'C');
$pdf->Ln(2);

// Header Tabel
$pdf->SetFont('Times', 'B', 10);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
$pdf->Cell(50, 8, 'Nama Petugas', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'NIP', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'Aksi', 1, 0, 'C', true);
$pdf->Cell(60, 8, 'Nama Barang', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Masuk', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Keluar', 1, 0, 'C', true);
$pdf->Cell(47, 8, 'Tanggal', 1, 1, 'C', true);

// Isi Tabel
$pdf->SetFont('Times', '', 10);
$sql = "SELECT id_riwayat, nama_user, nip, nama_barang, jenis_aktivitas, jumlah, tanggal
        FROM riwayat_barang
        ORDER BY tanggal DESC, id_riwayat DESC";
$result = mysqli_query($koneksi, $sql);

$no = 1;
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $aksi = strtolower($row['jenis_aktivitas']) === 'masuk' ? 'Barang Masuk' : 'Barang Keluar';
        $qtyMasuk  = strtolower($row['jenis_aktivitas']) === 'masuk' ? number_format($row['jumlah']) : '-';
        $qtyKeluar = strtolower($row['jenis_aktivitas']) === 'keluar' ? number_format($row['jumlah']) : '-';
        $tanggal   = date('d-m-Y H:i', strtotime($row['tanggal']));

        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(50, 7, iconv('UTF-8', 'ISO-8859-1', $row['nama_user'] ?: '-'), 1, 0);
        $pdf->Cell(35, 7, $row['nip'] ?: '-', 1, 0, 'C');
        $pdf->Cell(35, 7, $aksi, 1, 0, 'C');
        $pdf->Cell(60, 7, iconv('UTF-8', 'ISO-8859-1', $row['nama_barang'] ?: '-'), 1, 0);
        $pdf->Cell(20, 7, $qtyMasuk, 1, 0, 'C');
        $pdf->Cell(20, 7, $qtyKeluar, 1, 0, 'C');
        $pdf->Cell(47, 7, $tanggal, 1, 1, 'C');
    }
} else {
    $pdf->Cell(277, 10, 'Belum ada data riwayat.', 1, 1, 'C');
}

// Bagian Tanda Tangan (disamakan dengan cetak.php)
$pdf->Ln(15);
$pdf->SetFont('Times', '', 11);
$pdf->Cell(200); // Geser lebih jauh ke kanan karena format Landscape
$pdf->Cell(70, 5, 'Banjarbaru, ' . date('d F Y'), 0, 1, 'C');
$pdf->Cell(200);
$pdf->Cell(70, 5, 'Mengetahui,', 0, 1, 'C');
$pdf->Cell(200);
$pdf->Cell(70, 5, 'Kepala Dinas', 0, 1, 'C');
$pdf->Ln(20);
$pdf->Cell(200);
$pdf->Cell(70, 5, '( ............................................... )', 0, 1, 'C');
$pdf->Cell(200);
$pdf->Cell(70, 5, 'NIP. 192837192837', 0, 1, 'C');

$pdf->Output('I', 'riwayat_aktivitas_dkp3.pdf');
exit;