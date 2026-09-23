<?php
require_once __DIR__ . '/../config/auth.php';
dkp_require_login();

require('../library/fpdf.php');
include '../config/koneksi.php';

class PDF extends FPDF
{
    var $widths;
    var $aligns;

    // Fungsi untuk menentukan lebar kolom
    function SetWidths($w)
    {
        $this->widths = $w;
    }

    // Fungsi untuk menentukan alignment (L, C, R)
    function SetAligns($a)
    {
        $this->aligns = $a;
    }

    // --- FUNGSI UTAMA: MEMBUAT BARIS TABEL OTOMATIS WRAPPING ---
    function Row($data)
    {
        // Hitung tinggi baris berdasarkan konten terbanyak
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        
        $h = 5 * $nb; // 5 adalah tinggi per satu baris teks (bisa diubah)
        
        // Cek apakah halaman cukup, jika tidak tambah halaman baru
        $this->CheckPageBreak($h);
        
        // Gambar sel
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; // Default Left
            
            // Simpan posisi X dan Y saat ini
            $x = $this->GetX();
            $y = $this->GetY();
            
            // Gambar Border Kotak
            $this->Rect($x, $y, $w, $h);
            
            // Cetak Teks (MultiCell agar bisa turun baris)
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            
            // Kembalikan posisi Y ke atas dan geser X ke kolom berikutnya
            $this->SetXY($x + $w, $y);
        }
        
        // Pindah ke baris baru
        $this->Ln($h);
    }

    // Cek ganti halaman
    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    // Hitung jumlah baris teks
    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    // Setting Header (Kop Surat)
    function Header()
    {
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
        $this->Line(10, 36, 200, 36);
        $this->SetLineWidth(0);
        $this->Line(10, 37, 200, 37); 

        $this->Ln(10);
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
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Times', '', 11);

// Tangkap Parameter
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';

// =========================================================================
//  LOGIKA LAPORAN
// =========================================================================

if ($jenis == 'stok') {
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, 'LAPORAN DATA STOK BARANG', 0, 1, 'C');
    $pdf->Ln(2);

    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
    $pdf->Cell(80, 8, 'Nama Barang', 1, 0, 'L', true);
    $pdf->Cell(40, 8, 'Kategori', 1, 0, 'L', true);
    $pdf->Cell(30, 8, 'Satuan', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Stok', 1, 1, 'C', true);

    $pdf->SetFont('Times', '', 10);
    // Setting Lebar Kolom untuk Row()
    $pdf->SetWidths(array(10, 80, 40, 30, 30));
    $pdf->SetAligns(array('C', 'L', 'L', 'C', 'C'));

    $query = mysqli_query($koneksi, "SELECT b.*, k.nama_kategori FROM barang b JOIN kategori k ON b.id_kategori=k.id_kategori ORDER BY b.nama_barang");
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        // Gunakan Row, bukan Cell
        $pdf->Row(array(
            $no++, 
            $row['nama_barang'], 
            $row['nama_kategori'], 
            $row['satuan'], 
            $row['stok']
        ));
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
    
    // Setting Lebar Kolom (Total harus <= 190 untuk A4 Portrait)
    $pdf->SetWidths(array(10, 30, 80, 20, 50));
    $pdf->SetAligns(array('C', 'C', 'L', 'C', 'L'));

    $query = mysqli_query($koneksi, "SELECT m.*, b.nama_barang FROM barang_masuk m JOIN barang b ON m.id_barang=b.id_barang WHERE m.tanggal BETWEEN '$tgl1' AND '$tgl2'");
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $pdf->Row(array(
            $no++,
            date('d-m-Y', strtotime($row['tanggal'])),
            $row['nama_barang'],
            $row['jumlah'],
            $row['keterangan'] // Ini akan otomatis ke bawah jika panjang
        ));
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

    // Setting Lebar Kolom
    $pdf->SetWidths(array(10, 30, 60, 15, 40, 35));
    $pdf->SetAligns(array('C', 'C', 'L', 'C', 'L', 'L'));

    $query = mysqli_query($koneksi, "SELECT k.*, b.nama_barang FROM barang_keluar k JOIN barang b ON k.id_barang=b.id_barang WHERE k.tanggal BETWEEN '$tgl1' AND '$tgl2'");
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $pdf->Row(array(
            $no++,
            date('d-m-Y', strtotime($row['tanggal'])),
            $row['nama_barang'],
            $row['jumlah'],
            $row['penerima'],
            $row['keterangan'] // Ini akan wrap otomatis
        ));
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
    
    $pdf->SetWidths(array(10, 100, 40, 40));
    $pdf->SetAligns(array('C', 'L', 'C', 'C'));

    $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_kategori='$id_kat'");
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $pdf->Row(array(
            $no++,
            $row['nama_barang'],
            $row['satuan'],
            $row['stok']
        ));
    }

} elseif ($jenis == 'menipis') {
    // Logika Menipis tidak saya ubah ke Row karena jarang ada teks panjang
    // Tapi jika mau diubah silakan sesuaikan seperti di atas
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
$pdf->Ln(15);

// Jika sisa halaman sedikit, pindah halaman dulu buat TTD
if ($pdf->GetY() > 240) {
    $pdf->AddPage();
}

$pdf->SetFont('Times', '', 11);
$pdf->Cell(120); 
$pdf->Cell(70, 5, 'Banjarbaru, ' . date('d F Y'), 0, 1, 'C');
$pdf->Cell(120);
$pdf->Cell(70, 5, 'Mengetahui,', 0, 1, 'C');
$pdf->Cell(120);
$pdf->Cell(70, 5, 'Kepala Dinas', 0, 1, 'C');
$pdf->Ln(25); 
$pdf->Cell(120);
$pdf->Cell(70, 5, '( ............................................... )', 0, 1, 'C');
$pdf->Cell(120);
$pdf->Cell(70, 5, 'NIP. 192837192837', 0, 1, 'C');

$pdf->Output();
?>
