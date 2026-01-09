<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar.php'; ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">Data Barang ATK</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg"></i> Tambah Barang
        </button>
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Foto</th> <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT b.*, k.nama_kategori FROM barang b 
                          LEFT JOIN kategori k ON b.id_kategori = k.id_kategori 
                          ORDER BY b.id_barang DESC";
                $result = mysqli_query($koneksi, $query);
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    // Cek ada foto atau tidak
                    $foto = $row['foto'];
                    if ($foto == null || $foto == "") {
                        $img_src = "../assets/img_barang/default.png"; // Gambar pengganti jika kosong
                    } else {
                        $img_src = "../assets/img_barang/" . $foto;
                    }
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <img src="<?= $img_src; ?>" alt="Foto" width="50" height="50" class="object-fit-cover rounded border">
                    </td>
                    <td><?= $row['nama_barang']; ?></td>
                    <td><span class="badge bg-info text-dark"><?= $row['nama_kategori']; ?></span></td>
                    <td><?= $row['satuan']; ?></td>
                    <td>
                        <?php if($row['stok'] < 5): ?>
                            <span class="text-danger fw-bold"><?= $row['stok']; ?> (Menipis)</span>
                        <?php else: ?>
                            <?= $row['stok']; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="../proses/hapus_barang.php?id=<?= $row['id_barang']; ?>&foto=<?= $row['foto']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="../proses/proses_barang.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Foto Barang (Opsional)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG. Maks 2MB.</small>
                    </div>
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <?php
                            $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
                            while ($k = mysqli_fetch_assoc($kat)) {
                                echo "<option value='{$k['id_kategori']}'>{$k['nama_kategori']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Satuan (Pcs, Rim, Kotak)</label>
                        <input type="text" name="satuan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Stok Awal</label>
                        <input type="number" name="stok" class="form-control" value="0" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>