<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 fw-bold">Riwayat Aktivitas</h1>
                    <p class="text-muted small mb-0">Log transaksi barang masuk dan keluar</p>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="cetak_riwayat.php" target="_blank" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width:50px;">#</th>
                                    <th>Petugas</th>
                                    <th>NIP</th>
                                    <th class="text-center">Status</th>
                                    <th>Nama Barang</th>
                                    <th class="text-end">Masuk</th>
                                    <th class="text-end">Keluar</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT id_riwayat, nama_user, nip, nama_barang, jenis_aktivitas, jumlah, tanggal
                                        FROM riwayat_barang
                                        ORDER BY tanggal DESC, id_riwayat DESC";

                                $no = 1;
                                $result = mysqli_query($koneksi, $sql);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $nama   = $row['nama_user'] ?: '-';
                                        $nip    = $row['nip'] ?: '-';
                                        $aksi   = strtolower($row['jenis_aktivitas']);
                                        $barang = $row['nama_barang'] ?: '-';
                                        $jumlah = (int)$row['jumlah'];
                                        $tgl    = date('d-m-Y H:i', strtotime($row['tanggal']));

                                        $isMasuk  = $aksi === 'masuk';
                                        $isKeluar = $aksi === 'keluar';

                                        $badgeClass = $isMasuk ? 'bg-success' : 'bg-danger';
                                        $aksiLabel  = $isMasuk ? 'Masuk' : 'Keluar';
                                        ?>
                                        <tr>
                                            <td class="text-center text-muted"><?= $no++; ?></td>
                                            <td class="fw-semibold"><?= htmlspecialchars($nama); ?></td>
                                            <td class="text-muted small"><?= htmlspecialchars($nip); ?></td>
                                            <td class="text-center">
                                                <span class="badge <?= $badgeClass; ?> rounded-pill">
                                                    <?= $aksiLabel; ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($barang); ?></td>
                                            <td class="text-end">
                                                <?php if ($isMasuk): ?>
                                                    <span class="text-success fw-semibold">+<?= number_format($jumlah); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <?php if ($isKeluar): ?>
                                                    <span class="text-danger fw-semibold">-<?= number_format($jumlah); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-muted small"><?= $tgl; ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                                <p class="mb-0">Belum ada riwayat aktivitas</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .content-wrapper {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .table thead th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .badge {
        padding: 0.35rem 0.75rem;
        font-weight: 500;
        font-size: 0.75rem;
    }

    .btn {
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
    }
</style>

<?php include '../layout/footer.php'; ?>