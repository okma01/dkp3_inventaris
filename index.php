<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<style>
    .card-stat {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .card-stat::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }
    
    .card-stat:hover::before {
        opacity: 1;
    }
    
    .icon-wrapper {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        transition: transform 0.3s ease;
    }
    
    .card-stat:hover .icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }
    
    .badge-date {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 12px 24px !important;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .text-primary-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .btn-quick-access {
        border: 2px solid;
        transition: all 0.3s ease;
        font-weight: 500;
        border-radius: 12px;
    }
    
    .btn-quick-access:hover {
        transform: translateX(10px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .chart-card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .chart-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    
    .card-header-custom {
        border-bottom: 3px solid #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(255,255,255,1) 100%) !important;
    }
</style>

<div class="container-fluid p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary-green fw-bold mb-2">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </h2>
            <p class="text-muted mb-0">
            Selamat datang, <strong><?= $_SESSION['nama_admin']; ?></strong>!
        </p>
        </div>
        <div>
            <span class="badge badge-date text-white">
                <i class="bi bi-calendar-check me-2"></i><?= date('d F Y'); ?>
            </span>
        </div>
    </div>

    <div class="row mb-4 g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm card-stat">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Barang</p>
                            <h3 class="mb-0 fw-bold text-success">
                                <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang")); ?>
                            </h3>
                            <small class="text-muted">Item Terdaftar</small>
                        </div>
                        <div class="icon-wrapper" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <i class="bi bi-box-seam fs-3 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm card-stat">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Riwayat Masuk</p>
                            <h3 class="mb-0 fw-bold text-info">
                                <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang_masuk")); ?>
                            </h3>
                            <small class="text-muted">Total Transaksi</small>
                        </div>
                        <div class="icon-wrapper" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                            <i class="bi bi-arrow-down-circle fs-3 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm card-stat">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Riwayat Keluar</p>
                            <h3 class="mb-0 fw-bold text-warning">
                                <?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang_keluar")); ?>
                            </h3>
                            <small class="text-muted">Total Transaksi</small>
                        </div>
                        <div class="icon-wrapper" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                            <i class="bi bi-arrow-up-circle fs-3 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <?php 
                $cek_tipis = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang WHERE stok < 5")); 
            ?>
            <div class="card border-0 shadow-sm card-stat">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Stok Menipis</p>
                            <h3 class="mb-0 fw-bold text-danger">
                                <?= $cek_tipis; ?>
                            </h3>
                            <small class="text-muted">Perlu Restok</small>
                        </div>
                        <div class="icon-wrapper" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                            <i class="bi bi-exclamation-triangle fs-3 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm chart-card h-100">
                <div class="card-header card-header-custom py-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-bar-chart-fill text-success me-2 fs-5"></i>
                        <h6 class="mb-0 fw-bold text-success">Statistik Stok per Kategori</h6>
                    </div>
                </div>
                <div class="card-body p-4">
                    <canvas id="stokChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm chart-card h-100">
                <div class="card-header card-header-custom py-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-lightning-charge-fill text-success me-2 fs-5"></i>
                        <h6 class="mb-0 fw-bold text-success">Akses Cepat</h6>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <a href="pages/barang_masuk.php" class="btn btn-quick-access btn-outline-success text-start p-3">
                            <i class="bi bi-plus-circle me-2"></i> Input Barang Masuk
                        </a>
                        <a href="pages/barang_keluar.php" class="btn btn-quick-access btn-outline-warning text-start p-3">
                            <i class="bi bi-dash-circle me-2"></i> Input Barang Keluar
                        </a>
                        <a href="pages/laporan.php" class="btn btn-quick-access btn-outline-info text-start p-3">
                            <i class="bi bi-printer me-2"></i> Cetak Laporan
                        </a>
                        <a href="pages/barang.php" class="btn btn-quick-access btn-outline-primary text-start p-3">
                            <i class="bi bi-box-seam me-2"></i> Kelola Data Barang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
// Ambil data kategori dan jumlah total stoknya
$labels_kategori = "";
$data_stok = "";

$query_chart = mysqli_query($koneksi, "SELECT k.nama_kategori, SUM(b.stok) as total_stok 
                                       FROM kategori k 
                                       LEFT JOIN barang b ON k.id_kategori = b.id_kategori 
                                       GROUP BY k.id_kategori");

while ($chart = mysqli_fetch_assoc($query_chart)) {
    $nama = $chart['nama_kategori'];
    $total = $chart['total_stok'] == NULL ? 0 : $chart['total_stok'];
    
    $labels_kategori .= "'$nama',";
    $data_stok .= "$total,";
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('stokChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [<?= $labels_kategori; ?>],
      datasets: [{
        label: 'Jumlah Stok',
        data: [<?= $data_stok; ?>],
        backgroundColor: [
          'rgba(16, 185, 129, 0.8)',   // Hijau primary
          'rgba(6, 182, 212, 0.8)',    // Cyan
          'rgba(34, 197, 94, 0.8)',    // Hijau terang
          'rgba(20, 184, 166, 0.8)',   // Teal
          'rgba(5, 150, 105, 0.8)',    // Hijau gelap
          'rgba(14, 165, 233, 0.8)',   // Biru
          'rgba(16, 185, 129, 0.6)',   // Hijau transparan
        ],
        borderColor: [
          'rgba(16, 185, 129, 1)',
          'rgba(6, 182, 212, 1)',
          'rgba(34, 197, 94, 1)',
          'rgba(20, 184, 166, 1)',
          'rgba(5, 150, 105, 1)',
          'rgba(14, 165, 233, 1)',
          'rgba(16, 185, 129, 1)',
        ],
        borderWidth: 2,
        borderRadius: 8,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          display: true,
          position: 'bottom',
          labels: {
            padding: 15,
            font: {
              size: 12,
              family: "'Inter', sans-serif"
            }
          }
        },
        tooltip: {
          backgroundColor: 'rgba(16, 185, 129, 0.9)',
          padding: 12,
          cornerRadius: 8,
          titleFont: {
            size: 14,
            weight: 'bold'
          },
          bodyFont: {
            size: 13
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(0, 0, 0, 0.05)',
            drawBorder: false
          },
          ticks: {
            font: {
              size: 11
            }
          }
        },
        x: {
          grid: {
            display: false,
            drawBorder: false
          },
          ticks: {
            font: {
              size: 11
            }
          }
        }
      },
      animation: {
        duration: 1000,
        easing: 'easeInOutQuart'
      }
    }
  });
</script>

<?php include 'layout/footer.php'; ?>