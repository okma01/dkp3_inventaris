<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar.php'; ?>

<style>
    .report-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    
    .report-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, rgba(255,255,255,0.5) 0%, rgba(255,255,255,0.8) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .report-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
    }
    
    .report-card:hover::before {
        opacity: 1;
    }
    
    .card-header-gradient {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 15px;
    }
    
    .card-header-gradient-blue {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }
    
    .card-header-gradient-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .card-header-gradient-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }
    
    .card-header-gradient-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    
    .btn-print {
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-print:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    
    .btn-print i {
        margin-right: 8px;
        font-size: 1.1rem;
    }
    
    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .page-title {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }
    
    .page-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
    }
    
    .input-group .btn {
        border-radius: 0 10px 10px 0 !important;
    }
    
    .card-number {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    .alert-pengadaan {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.05) 100%);
        border: 2px solid #ef4444;
        border-radius: 12px;
        padding: 1.5rem;
    }
    
    @keyframes pulse-border {
        0%, 100% { border-color: #ef4444; }
        50% { border-color: #dc2626; }
    }
    
    .alert-pengadaan {
        animation: pulse-border 2s infinite;
    }
</style>

<div class="container-fluid p-4">
    <div class="mb-5">
        <h2 class="page-title">
            <i class="bi bi-file-earmark-text me-2"></i>Pusat Laporan & Cetak
        </h2>
        <p class="page-subtitle">
            <i class="bi bi-info-circle me-1"></i>
            Kelola dan cetak berbagai laporan inventaris dengan mudah
        </p>
    </div>
    
    <div class="row g-4">
        <!-- Card 1: Laporan Stok Barang -->
        <div class="col-md-6">
            <div class="card report-card shadow-sm h-100">
                <div class="card-header card-header-gradient text-white position-relative">
                    <i class="bi bi-box-seam me-2"></i>Laporan Stok Barang
                </div>
                <div class="card-body p-4">
                    <p class="card-text text-muted mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Mencetak semua data barang beserta sisa stok saat ini dalam format PDF.
                    </p>
                    <a href="cetak.php?jenis=stok" target="_blank" class="btn btn-success btn-print w-100">
                        <i class="bi bi-printer-fill"></i> Cetak Semua Stok
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Laporan Barang Masuk -->
        <div class="col-md-6">
            <div class="card report-card shadow-sm h-100">
                <div class="card-header card-header-gradient-blue text-white position-relative">
                    <i class="bi bi-arrow-down-circle me-2"></i>Laporan Barang Masuk
                </div>
                <div class="card-body p-4">
                    <form action="cetak.php" method="GET" target="_blank">
                        <input type="hidden" name="jenis" value="masuk">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="bi bi-calendar-range me-1"></i>Periode Laporan
                                </label>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small">Dari Tanggal</label>
                                <input type="date" name="tgl_awal" class="form-control" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small">Sampai Tanggal</label>
                                <input type="date" name="tgl_akhir" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-info btn-print w-100" title="Cetak Laporan">
                                    <i class="bi bi-printer-fill"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card 3: Laporan Barang Keluar -->
        <div class="col-md-6">
            <div class="card report-card shadow-sm h-100">
                <div class="card-header card-header-gradient-orange text-white position-relative">
                    <i class="bi bi-arrow-up-circle me-2"></i>Laporan Barang Keluar
                </div>
                <div class="card-body p-4">
                    <form action="cetak.php" method="GET" target="_blank">
                        <input type="hidden" name="jenis" value="keluar">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="bi bi-calendar-range me-1"></i>Periode Laporan
                                </label>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small">Dari Tanggal</label>
                                <input type="date" name="tgl_awal" class="form-control" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small">Sampai Tanggal</label>
                                <input type="date" name="tgl_akhir" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-warning btn-print w-100" title="Cetak Laporan">
                                    <i class="bi bi-printer-fill"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card 4: Laporan Per Kategori -->
        <div class="col-md-6">
            <div class="card report-card shadow-sm h-100">
                <div class="card-header card-header-gradient-purple text-white position-relative">
                    <i class="bi bi-tags me-2"></i>Laporan Per Kategori
                </div>
                <div class="card-body p-4">
                    <form action="cetak.php" method="GET" target="_blank">
                        <input type="hidden" name="jenis" value="kategori">
                        <label class="form-label fw-semibold text-muted">
                            <i class="bi bi-funnel me-1"></i>Pilih Kategori
                        </label>
                        <div class="input-group">
                            <select name="id_kategori" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                <?php
                                $kat = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                                while ($k = mysqli_fetch_assoc($kat)) {
                                    echo "<option value='{$k['id_kategori']}'>{$k['nama_kategori']}</option>";
                                }
                                ?>
                            </select>
                            <button class="btn btn-purple text-white" type="submit" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                                <i class="bi bi-printer-fill me-1"></i> Cetak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card 5: Laporan Stok Menipis (Full Width) -->
        <div class="col-12">
            <div class="card report-card shadow-sm alert-pengadaan">
                <div class="card-header card-header-gradient-red text-white position-relative">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Laporan Stok Menipis & Pengadaan
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h6 class="mb-2 fw-bold text-danger">
                                <i class="bi bi-clipboard-data me-2"></i>Laporan Pengadaan Barang
                            </h6>
                            <p class="mb-0 text-muted">
                                Laporan ini menampilkan barang dengan stok kurang dari 5 unit. Digunakan untuk pengajuan pengadaan barang baru ke pihak terkait.
                            </p>
                        </div>
                        <a href="cetak.php?jenis=menipis" target="_blank" class="btn btn-danger btn-print">
                            <i class="bi bi-exclamation-triangle-fill"></i> Cetak Laporan Pengadaan
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Info Footer -->
    <div class="alert alert-info mt-4 border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(8, 145, 178, 0.05) 100%);">
        <div class="d-flex align-items-start">
            <i class="bi bi-lightbulb-fill text-info fs-4 me-3"></i>
            <div>
                <h6 class="alert-heading fw-bold text-info mb-2">Tips Penggunaan</h6>
                <ul class="mb-0 small">
                    <li>Semua laporan akan dibuka di tab baru dalam format PDF</li>
                    <li>Pastikan pop-up browser tidak diblokir untuk melihat hasil cetak</li>
                    <li>Gunakan fitur "Save as PDF" di browser untuk menyimpan laporan</li>
                    <li>Laporan dengan filter tanggal akan menampilkan data sesuai periode yang dipilih</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>