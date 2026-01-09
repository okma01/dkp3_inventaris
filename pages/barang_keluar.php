<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar.php'; ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 text-warning">Riwayat Barang Keluar</h5>
        <button type="button" class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalKeluar">
            <i class="bi bi-dash-lg"></i> Input Barang Keluar
        </button>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Penerima</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT k.*, b.nama_barang, b.satuan 
                          FROM barang_keluar k 
                          JOIN barang b ON k.id_barang = b.id_barang 
                          ORDER BY k.tanggal DESC, k.id_keluar DESC";
                $result = mysqli_query($koneksi, $query);
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                    <td><?= $row['nama_barang']; ?></td>
                    <td class="fw-bold text-danger">- <?= $row['jumlah'] . ' ' . $row['satuan']; ?></td>
                    <td><?= $row['penerima']; ?></td>
                    <td><?= $row['keterangan']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalKeluar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Catat Barang Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="../proses/proses_keluar.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Pilih Barang</label>
                        <select name="id_barang" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php
                            // Hanya tampilkan barang yang stoknya > 0
                            $brg = mysqli_query($koneksi, "SELECT * FROM barang WHERE stok > 0 ORDER BY nama_barang ASC");
                            while ($b = mysqli_fetch_assoc($brg)) {
                                echo "<option value='{$b['id_barang']}'>{$b['nama_barang']} (Sisa: {$b['stok']})</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Keluar</label>
                        <input type="number" name="jumlah" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label>Penerima (Bidang/Nama Orang)</label>
                        <input type="text" name="penerima" class="form-control" placeholder="Contoh: Bidang Perikanan" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="simpan_keluar" class="btn btn-warning text-white">Simpan & Kurangi Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>