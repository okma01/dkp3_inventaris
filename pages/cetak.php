<?php
require('../library/fpdf.php');
include '../config/koneksi.php';

class PDF extends FPDF
{
    // Setting Header (Kop Surat)
    function Header()
    {
        // 1. Logo (X=10, Y=6, Lebar=23)
        // Pastikan path logo benar.
        if (file_exists('../assets/logo.png')) {
            $this->Image('../assets/logo.png', 10, 6, 23); 
        }

        // --- PENGATURAN TEKS KOP SURAT ---
        // Logikanya: Setiap mau nulis baris (Cell), kita geser dulu X-nya ke 34
        // supaya tidak menimpa logo (Logo ada di X=10 sampai X=33).

        // Baris 1: PEMERINTAH KOTA...
        $this->SetFont('Times', 'B', 13);
        $this->SetX(34); // Geser ke kanan melewati logo
        $this->Cell(0, 6, 'PEMERINTAH KOTA BANJARBARU', 0, 1, 'C');

        // Baris 2: NAMA DINAS (Font Besar)
        $this->SetFont('Times', 'B', 15);
        $this->SetX(34); // Geser ke kanan
        $this->Cell(0, 6, 'DINAS KETAHANAN PANGAN, PERTANIAN DAN PERIKANAN', 0, 1, 'C');

        // Baris 3: Alamat
        $this->SetFont('Times', '', 10);
        $this->SetX(34); // Geser ke kanan
        $this->Cell(0, 5, 'Alamat : Jl. Agus Salim, Banjarbaru Telp/ Fax. (0511) 4781050', 0, 1, 'C');

        // Baris 4: Website & Email
        $this->SetX(34); // Geser ke kanan
        $this->Cell(0, 5, 'Website : www.dkp3.banjarbarukota.go.id   E-mail : dkp3@banjarbarukota.go.id', 0, 1, 'C');

        // 3. Garis Bawah Kop (Tebal)
        $this->Ln(4); // Spasi ke bawah sedikit
        $this->SetLineWidth(1); // Menebalkan garis
        $this->Line(10, 36, 200, 36); // Garis tebal
        $this->SetLineWidth(0); // Kembalikan normal
        
        // Garis tipis kedua (Pemanis)
        $this->Line(10, 37, 200, 37); 

        $this->Ln(10); // Jarak antara Kop dan Isi Laporan
    }

    // Setting Footer (Nomor Halaman)
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' - Dicetak pada: ' . date('d-m-Y H:i'), 0, 0, 'C');
    }
}

// --- Mulai Pembuatan PDF ---
$pdf = new PDF('P', 'mm', 'A4'); // P = Portrait, mm = milimeter, A4
$pdf->AddPage();
$pdf->SetFont('Times', '', 11);

// Tangkap Parameter Filter (Menggunakan null coalescing '??' agar tidak error jika kosong)
$jenis = $_GET['jenis'] ?? '';

// =========================================================================
//  LOGIKA LAPORAN
// =========================================================================

if ($jenis == 'stok') {
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, 'LAPORAN DATA STOK BARANG', 0, 1, 'C');
    $pdf->Ln(2);

    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetFillColor(230, 230, 230); // Abu-abu
    $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
    $pdf->Cell(80, 8, 'Nama Barang', 1, 0, 'L', true);
    $pdf->Cell(40, 8, 'Kategori', 1, 0, 'L', true);
    $pdf->Cell(30, 8, 'Satuan', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Stok', 1, 1, 'C', true);

    $pdf->SetFont('Times', '', 10);
    $query = mysqli_query($koneksi, "SELECT b.*, k.nama_kategori FROM barang b JOIN kategori k ON b.id_kategori=k.id_kategori ORDER BY b.nama_barang");
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(80, 7, $row['nama_barang'], 1, 0);
        $pdf->Cell(40, 7, $row['nama_kategori'], 1, 0);
        $pdf->Cell(30, 7, $row['satuan'], 1, 0, 'C');
        $pdf->Cell(30, 7, $row['stok'], 1, 1, 'C');
    }

} elseif ($jenis == 'masuk') {
    $tgl1 = $_GET['tgl_awal'] ?? date('Y-m-d');
    $tgl2 = $_GET['tgl_akhir'] ?? date('Y-m-d');

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, 'LAPORAN BARANG MASUK', 0, 1, 'C');
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(0, 5, 'Periode: ' . date('d-m-Y', strtotime($tgl1)) . ' s/d ' . date('d-m-Y', strtotime($tgl2)), 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Tanggal', 1, 0, 'C', true);
    $pdf->Cell(80, 8, 'Nama Barang', 1, 0, 'L', true);
    $pdf->Cell(20, 8, 'Jml', 1, 0, 'C', true);
    $pdf->Cell(50, 8, 'Keterangan', 1, 1, 'L', true);

    $pdf->SetFont('Times', '', 10);
    $query = mysqli_query($koneksi, "SELECT m.*, b.nama_barang FROM barang_masuk m JOIN barang b ON m.id_barang=b.id_barang WHERE m.tanggal BETWEEN '$tgl1' AND '$tgl2'");
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(30, 7, date('d-m-Y', strtotime($row['tanggal'])), 1, 0);
        $pdf->Cell(80, 7, $row['nama_barang'], 1, 0);
        $pdf->Cell(20, 7, $row['jumlah'], 1, 0, 'C');
        $pdf->Cell(50, 7, $row['keterangan'], 1, 1);
    }

} elseif ($jenis == 'keluar') {
    $tgl1 = $_GET['tgl_awal'] ?? date('Y-m-d');
    $tgl2 = $_GET['tgl_akhir'] ?? date('Y-m-d');

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, 'LAPORAN BARANG KELUAR', 0, 1, 'C');
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(0, 5, 'Periode: ' . date('d-m-Y', strtotime($tgl1)) . ' s/d ' . date('d-m-Y', strtotime($tgl2)), 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Tanggal', 1, 0, 'C', true);
    $pdf->Cell(60, 8, 'Nama Barang', 1, 0, 'L', true);
    $pdf->Cell(15, 8, 'Jml', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Penerima', 1, 0, 'L', true);
    $pdf->Cell(35, 8, 'Ket', 1, 1, 'L', true);

    $pdf->SetFont('Times', '', 10);
    $query = mysqli_query($koneksi, "SELECT k.*, b.nama_barang FROM barang_keluar k JOIN barang b ON k.id_barang=b.id_barang WHERE k.tanggal BETWEEN '$tgl1' AND '$tgl2'");
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(30, 7, date('d-m-Y', strtotime($row['tanggal'])), 1, 0);
        $pdf->Cell(60, 7, $row['nama_barang'], 1, 0);
        $pdf->Cell(15, 7, $row['jumlah'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['penerima'], 1, 0);
        $pdf->Cell(35, 7, $row['keterangan'], 1, 1);
    }

} elseif ($jenis == 'kategori') {
    $id_kat = $_GET['id_kategori'] ?? 0;
    
    $get_k = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama_kategori FROM kategori WHERE id_kategori='$id_kat'"));
    $nama_kategori = $get_k['nama_kategori'] ?? 'Tidak Diketahui';

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, 'LAPORAN BARANG KATEGORI: ' . strtoupper($nama_kategori), 0, 1, 'C');
    $pdf->Ln(2);

    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
    $pdf->Cell(100, 8, 'Nama Barang', 1, 0, 'L', true);
    $pdf->Cell(40, 8, 'Satuan', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Sisa Stok', 1, 1, 'C', true);

    $pdf->SetFont('Times', '', 10);
    $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_kategori='$id_kat'");
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(100, 7, $row['nama_barang'], 1, 0);
        $pdf->Cell(40, 7, $row['satuan'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['stok'], 1, 1, 'C');
    }

} elseif ($jenis == 'menipis') {
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetTextColor(255, 0, 0); 
    $pdf->Cell(0, 10, 'LAPORAN BARANG STOK MENIPIS', 0, 1, 'C');
    $pdf->SetTextColor(0, 0, 0); 
    $pdf->Ln(2);

    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
    $pdf->Cell(90, 8, 'Nama Barang', 1, 0, 'L', true);
    $pdf->Cell(50, 8, 'Kategori', 1, 0, 'L', true);
    $pdf->Cell(40, 8, 'Sisa Stok', 1, 1, 'C', true);

    $pdf->SetFont('Times', '', 10);
    $query = mysqli_query($koneksi, "SELECT b.*, k.nama_kategori FROM barang b JOIN kategori k ON b.id_kategori=k.id_kategori WHERE b.stok < 5 ORDER BY b.stok ASC");
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(90, 7, $row['nama_barang'], 1, 0);
        $pdf->Cell(50, 7, $row['nama_kategori'], 1, 0);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(40, 7, $row['stok'], 1, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
    }
}

// Tanda Tangan
$pdf->Ln(20);
$pdf->SetFont('Times', '', 11);
$pdf->Cell(120); // Geser ke kanan
$pdf->Cell(70, 5, 'Banjarbaru, ' . date('d F Y'), 0, 1, 'C');
$pdf->Cell(120);
$pdf->Cell(70, 5, 'Mengetahui,', 0, 1, 'C');
$pdf->Cell(120);
$pdf->Cell(70, 5, 'Kepala Dinas', 0, 1, 'C');
$pdf->Ln(25); // Jarak Tanda Tangan
$pdf->Cell(120);
$pdf->Cell(70, 5, '( ............................................... )', 0, 1, 'C');
$pdf->Cell(120);
$pdf->Cell(70, 5, 'NIP. 192837192837', 0, 1, 'C');

$pdf->Output();
?>