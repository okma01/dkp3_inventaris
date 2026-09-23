<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }
    
    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        overflow: hidden;
    }
    
    .card-header-custom {
        background: white;
        padding: 20px 25px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .table-custom thead th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 15px;
        border: none;
    }

    .table-custom tbody td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f9f9f9;
        font-size: 0.95rem;
    }

    .table-custom tr:hover td {
        background-color: #f1fcf6; /* Hijau pudar saat hover */
    }

    .img-barang {
        width: 55px;
        height: 55px;
        border-radius: 10px;
        object-fit: cover;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    
    .img-barang:hover { transform: scale(1.1); }

    .badge-custom {
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .search-input {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 50px;
        padding-left: 20px;
        font-size: 0.9rem;
    }
    
    .search-input:focus {
        background: white;
        border-color: #1e7256;
        box-shadow: 0 0 0 4px rgba(30, 114, 86, 0.1);
    }

    .btn-action {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .btn-add {
        background: #1e7256;
        color: white;
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 500;
        box-shadow: 0 4px 10px rgba(30, 114, 86, 0.2);
        border: none;
        transition: transform 0.2s;
    }
    
    .btn-add:hover { transform: translateY(-2px); background: #165c45; color: white; }
</style>

<div class="container-fluid p-4">
    
    <div class="card card-custom">
        <div class="card-header-custom">
            <div>
                <h4 class="mb-0 fw-bold text-dark">Data Barang</h4>
                <small class="text-muted">Kelola stok inventaris ATK</small>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <form action="" method="GET" class="d-flex position-relative">
                    <input type="text" name="cari" class="form-control search-input" placeholder="Cari barang..." 
                           value="<?php if(isset($_GET['cari'])){ echo $_GET['cari']; } ?>" style="width: 250px;">
                    <button class="btn position-absolute end-0 top-0 border-0" type="submit" style="color: #1e7256;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <?php if(isset($_GET['cari'])): ?>
                    <a href="barang.php" class="btn btn-light rounded-circle text-danger shadow-sm" title="Reset" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-x-lg"></i>
                    </a>
                <?php endif; ?>

                <?php if($_SESSION['level'] != 'pimpinan') : ?>
                    <button type="button" class="btn-add ms-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Baru
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Gambar</th> 
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Logika Pencarian
                        $where = "";
                        if(isset($_GET['cari'])){
                            $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
                            $where = "WHERE b.nama_barang LIKE '%$cari%' OR k.nama_kategori LIKE '%$cari%'";
                        }

                        $query = "SELECT b.*, k.nama_kategori FROM barang b 
                                  LEFT JOIN kategori k ON b.id_kategori = k.id_kategori 
                                  $where
                                  ORDER BY b.id_barang DESC";
                        
                        $result = mysqli_query($koneksi, $query);
                        $no = 1;

                        if(mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)) {
                                $foto = $row['foto'];
                                $img_src = ($foto && $foto != "") ? "../assets/img_barang/" . $foto : "../assets/img_barang/default.png";
                            ?>
                            <tr>
                                <td class="text-center text-muted"><?= $no++; ?></td>
                                <td class="text-center">
                                    <img src="<?= $img_src; ?>" alt="Barang" class="img-barang">
                                </td>
                                <td class="fw-medium text-dark"><?= $row['nama_barang']; ?></td>
                                <td>
                                    <span class="badge bg-light text-primary border border-primary-subtle badge-custom">
                                        <?= $row['nama_kategori']; ?>
                                    </span>
                                </td>
                                <td class="text-muted"><?= $row['satuan']; ?></td>
                                <td class="text-center">
                                    <?php if($row['stok'] < 5): ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger badge-custom">
                                            <i class="bi bi-exclamation-circle me-1"></i><?= $row['stok']; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-10 text-success badge-custom">
                                            <?= $row['stok']; ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center">
                                    <a href="detail_barang.php?id=<?= $row['id_barang']; ?>" 
                                       class="btn-action bg-info bg-opacity-10 text-info me-1" title="Detail">
                                       <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if($_SESSION['level'] != 'pimpinan') : ?>
                                    <a href="edit_data_barang.php?id=<?= $row['id_barang']; ?>" 
                                       class="btn-action bg-warning bg-opacity-10 text-warning me-1" title="Edit">
                                       <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="../proses/hapus_barang.php?id=<?= $row['id_barang']; ?>" 
                                       class="btn-action bg-danger bg-opacity-10 text-danger" 
                                       onclick="return confirm('Hapus barang ini permanen?')" title="Hapus">
                                       <i class="bi bi-trash"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php 
                            } 
                        } else {
                            echo "<tr><td colspan='7' class='text-center py-5 text-muted'><i class='bi bi-inbox fs-1 d-block mb-2'></i>Data tidak ditemukan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-white border-bottom-0 p-4">
                <h5 class="modal-title fw-bold text-primary">Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="../proses/proses_barang.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4 pt-0">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold text-uppercase">Informasi Barang</label>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating mb-3">
                                <input type="text" name="nama_barang" class="form-control rounded-3" id="namaBrg" placeholder="Nama Barang" required>
                                <label for="namaBrg">Nama Barang</label>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="id_kategori" class="form-select rounded-3" id="kat" required>
                                            <option value="">Pilih...</option>
                                            <?php
                                            $kat = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                                            while ($k = mysqli_fetch_assoc($kat)) { echo "<option value='{$k['id_kategori']}'>{$k['nama_kategori']}</option>"; }
                                            ?>
                                        </select>
                                        <label for="kat">Kategori</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="satuan" class="form-control rounded-3" id="satuan" placeholder="Pcs/Box" required>
                                        <label for="satuan">Satuan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light border-0 h-100 d-flex justify-content-center align-items-center text-center p-3 rounded-3">
                                <i class="bi bi-image fs-1 text-muted mb-2"></i>
                                <label class="form-label small text-muted">Upload Foto (Opsional)</label>
                                <input type="file" name="foto" class="form-control form-control-sm mt-2" accept="image/*">
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Persediaan Awal</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-layers"></i></span>
                                <input type="number" name="stok" class="form-control border-start-0" value="0" min="0" placeholder="Stok Awal">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 p-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" class="btn btn-primary rounded-pill px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>