<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<?php
$total_barang = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang"));
$total_masuk = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang_masuk"));
$total_keluar = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang_keluar"));
$stok_tipis = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang WHERE stok < 5"));

$total_stok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COALESCE(SUM(stok), 0) AS total FROM barang"))['total'];
$barang_terbaru = mysqli_query($koneksi, "SELECT b.*, k.nama_kategori
                                          FROM barang b
                                          LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
                                          ORDER BY b.id_barang DESC
                                          LIMIT 5");

$chart_labels = [];
$chart_data = [];
$query_chart = mysqli_query($koneksi, "SELECT k.nama_kategori, COALESCE(SUM(b.stok), 0) AS total_stok
                                       FROM kategori k
                                       LEFT JOIN barang b ON k.id_kategori = b.id_kategori
                                       GROUP BY k.id_kategori, k.nama_kategori
                                       ORDER BY k.nama_kategori ASC");

while ($chart = mysqli_fetch_assoc($query_chart)) {
    $chart_labels[] = $chart['nama_kategori'];
    $chart_data[] = (int) $chart['total_stok'];
}
?>

<div class="container-fluid p-4">
    <section class="dashboard-hero mb-4">
        <div>
            <span class="dashboard-eyebrow">Dashboard Inventaris</span>
            <h1>Ringkasan stok hari ini</h1>
            <p>Monitoring barang, transaksi masuk-keluar, dan kebutuhan restok dalam satu tampilan.</p>
        </div>
        <div class="dashboard-hero-meta">
            <div class="small text-white-50">Total stok tersedia</div>
            <strong><?= number_format($total_stok); ?></strong>
            <span><?= date('d F Y'); ?></span>
        </div>
    </section>

    <div class="dashboard-stat-grid mb-4">
        <article class="dashboard-stat-card">
            <div>
                <span>Total Barang</span>
                <strong><?= number_format($total_barang); ?></strong>
                <small>Item terdaftar</small>
            </div>
            <i class="bi bi-box-seam"></i>
        </article>

        <article class="dashboard-stat-card stat-info">
            <div>
                <span>Barang Masuk</span>
                <strong><?= number_format($total_masuk); ?></strong>
                <small>Total transaksi</small>
            </div>
            <i class="bi bi-arrow-down-circle"></i>
        </article>

        <article class="dashboard-stat-card stat-warning">
            <div>
                <span>Barang Keluar</span>
                <strong><?= number_format($total_keluar); ?></strong>
                <small>Total transaksi</small>
            </div>
            <i class="bi bi-arrow-up-circle"></i>
        </article>

        <article class="dashboard-stat-card stat-danger">
            <div>
                <span>Stok Menipis</span>
                <strong><?= number_format($stok_tipis); ?></strong>
                <small>Perlu restok</small>
            </div>
            <i class="bi bi-exclamation-triangle"></i>
        </article>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card dashboard-panel h-100">
                <div class="card-header-custom">
                    <div>
                        <h4 class="mb-0">Statistik Stok per Kategori</h4>
                        <small class="text-muted">Perbandingan jumlah stok pada setiap kategori barang</small>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="dashboard-chart-wrap">
                        <canvas id="stokChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card dashboard-panel h-100">
                <div class="card-header-custom">
                    <div>
                        <h4 class="mb-0">Akses Cepat</h4>
                        <small class="text-muted">Menu yang sering digunakan</small>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="quick-action-list">
                        <?php if($_SESSION['level'] != 'pimpinan') : ?>
                            <a href="pages/barang_masuk.php">
                                <i class="bi bi-plus-circle"></i>
                                <span>Input Barang Masuk</span>
                            </a>
                            <a href="pages/barang_keluar.php">
                                <i class="bi bi-dash-circle"></i>
                                <span>Input Barang Keluar</span>
                            </a>
                            <a href="pages/barang.php">
                                <i class="bi bi-box-seam"></i>
                                <span>Kelola Data Barang</span>
                            </a>
                        <?php endif; ?>
                        <a href="pages/laporan.php">
                            <i class="bi bi-printer"></i>
                            <span>Cetak Laporan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card dashboard-panel">
                <div class="card-header-custom">
                    <div>
                        <h4 class="mb-0">Barang Terbaru</h4>
                        <small class="text-muted">Lima data barang terakhir yang masuk ke sistem</small>
                    </div>
                    <a href="pages/barang.php" class="btn btn-outline-success">
                        <i class="bi bi-arrow-right me-1"></i>Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th class="text-end">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($barang_terbaru) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($barang_terbaru)): ?>
                                        <tr>
                                            <td class="fw-semibold"><?= htmlspecialchars($row['nama_barang']); ?></td>
                                            <td>
                                                <span class="badge bg-light text-success border border-success-subtle">
                                                    <?= htmlspecialchars($row['nama_kategori'] ?: 'Tanpa Kategori'); ?>
                                                </span>
                                            </td>
                                            <td class="text-muted"><?= htmlspecialchars($row['satuan']); ?></td>
                                            <td class="text-end">
                                                <?php if((int) $row['stok'] < 5): ?>
                                                    <span class="badge bg-danger"><?= number_format($row['stok']); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-success"><?= number_format($row['stok']); ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">Belum ada data barang.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('stokChart');

if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chart_labels); ?>,
            datasets: [{
                label: 'Jumlah Stok',
                data: <?= json_encode($chart_data); ?>,
                backgroundColor: ['#1f7a5c', '#19a7ce', '#f2b84b', '#5b8def', '#ef5350', '#2fbf71'],
                borderRadius: 12,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#17211d',
                    padding: 12,
                    cornerRadius: 10
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(23, 33, 29, 0.08)' },
                    ticks: { precision: 0 }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}
</script>

<?php include 'layout/footer.php'; ?>
