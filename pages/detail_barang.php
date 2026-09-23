<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar.php'; ?>

<?php
// Cek parameter id
if (!isset($_GET['id'])) {
    echo "<script>alert('ID Barang tidak ditemukan!'); window.location='barang.php';</script>";
    exit;
}

$id_barang = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT b.*, k.nama_kategori FROM barang b 
                                 LEFT JOIN kategori k ON b.id_kategori = k.id_kategori 
                                 WHERE b.id_barang = '$id_barang'");

if (mysqli_num_rows($query) == 0) {
    echo "<script>alert('Data barang tidak ditemukan!'); window.location='barang.php';</script>";
    exit;
}

$data = mysqli_fetch_assoc($query);
$foto = $data['foto'];
$img_src = ($foto && $foto != "") ? "../assets/img_barang/" . $foto : "../assets/img_barang/default.png";

// Ambil riwayat barang masuk
$q_masuk = mysqli_query($koneksi, "SELECT * FROM barang_masuk WHERE id_barang = '$id_barang' ORDER BY tanggal DESC LIMIT 10");

// Ambil riwayat barang keluar
$q_keluar = mysqli_query($koneksi, "SELECT * FROM barang_keluar WHERE id_barang = '$id_barang' ORDER BY tanggal DESC LIMIT 10");

// Hitung total masuk & keluar
$total_masuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COALESCE(SUM(jumlah),0) as total FROM barang_masuk WHERE id_barang = '$id_barang'"))['total'];
$total_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COALESCE(SUM(jumlah),0) as total FROM barang_keluar WHERE id_barang = '$id_barang'"))['total'];
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }

    .card-detail {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        overflow: hidden;
    }

    .card-header-detail {
        background: white;
        padding: 20px 25px;
        border-bottom: 2px solid #1e7256;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .img-detail {
        width: 200px;
        height: 200px;
        border-radius: 16px;
        object-fit: cover;
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        border: 4px solid #e9ecef;
    }

    .stat-card {
        border: none;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: transform 0.2s;
    }

    .stat-card:hover { transform: translateY(-3px); }

    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 1.05rem;
        font-weight: 500;
        color: #212529;
    }

    .table-history thead th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        padding: 12px 15px;
    }

    .table-history tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.9rem;
    }

    .btn-back-detail {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 500;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e7256;
        border-left: 4px solid #1e7256;
        padding-left: 12px;
        margin-bottom: 15px;
    }
</style>

<div class="container-fluid p-4">

    <!-- Header -->
    <div class="card card-detail mb-4">
        <div class="card-header-detail">
            <div>
                <h4 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-box-seam me-2 text-success"></i>Detail Barang
                </h4>
                <small class="text-muted">Informasi lengkap dan riwayat transaksi</small>
            </div>
            <a href="barang.php" class="btn btn-outline-secondary btn-back-detail">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <div class="card-body p-4">
            <div class="row g-4">
                <!-- Foto -->
                <div class="col-md-3 text-center">
                    <img src="<?= $img_src; ?>" alt="<?= htmlspecialchars($data['nama_barang']); ?>" class="img-detail mb-3">
                </div>

                <!-- Info Barang -->
                <div class="col-md-5">
                    <h3 class="fw-bold text-dark mb-3"><?= htmlspecialchars($data['nama_barang']); ?></h3>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="info-label">Kategori</div>
                            <div class="info-value">
                                <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2">
                                    <?= $data['nama_kategori'] ?: 'Tanpa Kategori'; ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-label">Satuan</div>
                            <div class="info-value"><?= htmlspecialchars($data['satuan']); ?></div>
                        </div>
                        <div class="col-6">
                            <div class="info-label">ID Barang</div>
                            <div class="info-value text-muted">#<?= $data['id_barang']; ?></div>
                        </div>
                        <div class="col-6">
                            <div class="info-label">Stok Saat Ini</div>
                            <div class="info-value">
                                <?php if($data['stok'] < 5): ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 fs-6">
                                        <i class="bi bi-exclamation-triangle me-1"></i><?= $data['stok']; ?> <?= $data['satuan']; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fs-6">
                                        <?= $data['stok']; ?> <?= $data['satuan']; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Ringkas -->
                <div class="col-md-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="stat-card bg-success bg-opacity-10">
                                <i class="bi bi-arrow-down-circle fs-3 text-success"></i>
                                <h3 class="fw-bold text-success mt-2 mb-0"><?= $total_masuk; ?></h3>
                                <small class="text-muted">Total Barang Masuk</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="stat-card bg-danger bg-opacity-10">
                                <i class="bi bi-arrow-up-circle fs-3 text-danger"></i>
                                <h3 class="fw-bold text-danger mt-2 mb-0"><?= $total_keluar; ?></h3>
                                <small class="text-muted">Total Barang Keluar</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Transaksi -->
    <div class="row g-4">
        <!-- Riwayat Masuk -->
        <div class="col-md-6">
            <div class="card card-detail">
                <div class="card-body p-4">
                    <div class="section-title">
                        <i class="bi bi-arrow-down-circle me-1"></i>Riwayat Barang Masuk (10 Terakhir)
                    </div>
                    <div class="table-responsive">
                        <table class="table table-history mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($q_masuk) > 0): ?>
                                    <?php while($m = mysqli_fetch_assoc($q_masuk)): ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($m['tanggal'])); ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">
                                                +<?= $m['jumlah']; ?>
                                            </span>
                                        </td>
                                        <td class="text-muted small"><?= $m['keterangan'] ?: '-'; ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Keluar -->
        <div class="col-md-6">
            <div class="card card-detail">
                <div class="card-body p-4">
                    <div class="section-title">
                        <i class="bi bi-arrow-up-circle me-1"></i>Riwayat Barang Keluar (10 Terakhir)
                    </div>
                    <div class="table-responsive">
                        <table class="table table-history mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Penerima</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($q_keluar) > 0): ?>
                                    <?php while($k = mysqli_fetch_assoc($q_keluar)): ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($k['tanggal'])); ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">
                                                -<?= $k['jumlah']; ?>
                                            </span>
                                        </td>
                                        <td class="text-muted small"><?= $k['penerima']; ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include '../layout/footer.php'; ?>
