<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar.php'; ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 text-success">Riwayat Barang Masuk</h5>
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalMasuk">
            <i class="bi bi-plus-lg"></i> Input Barang Masuk
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
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Join tabel barang_masuk dengan barang untuk ambil nama
                $query = "SELECT m.*, b.nama_barang, b.satuan 
                          FROM barang_masuk m 
                          JOIN barang b ON m.id_barang = b.id_barang 
                          ORDER BY m.tanggal DESC, m.id_masuk DESC";
                $result = mysqli_query($koneksi, $query);
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                    <td><?= $row['nama_barang']; ?></td>
                    <td class="fw-bold text-success">+ <?= $row['jumlah'] . ' ' . $row['satuan']; ?></td>
                    <td><?= $row['keterangan']; ?></td>
                    <td>
                        <a href="hapus_masuk.php?id=<?= $row['id_masuk']; ?>&idb=<?= $row['id_barang']; ?>&qty=<?= $row['jumlah']; ?>" 
                           class="btn btn-sm btn-outline-danger" 
                           onclick="return confirm('Hapus data ini? Stok akan dikembalikan.')">
                           <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalMasuk">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Tambah Stok Barang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="../proses/proses_masuk.php" method="POST">
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
                            $brg = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");
                            while ($b = mysqli_fetch_assoc($brg)) {
                                echo "<option value='{$b['id_barang']}'>{$b['nama_barang']} (Stok: {$b['stok']})</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Masuk</label>
                        <input type="number" name="jumlah" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan (Sumber Dana/Toko)</label>
                        <textarea name="keterangan" class="form-control" placeholder="Contoh: Pengadaan APBD 2024"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="simpan_masuk" class="btn btn-success">Simpan & Tambah Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>