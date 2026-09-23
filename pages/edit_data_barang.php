<?php
require_once __DIR__ . '/../config/auth.php';
dkp_require_roles(['admin', 'petugas']);
include '../layout/header.php';
?>
<?php include '../layout/sidebar.php'; ?>

<?php
// Cek apakah ada parameter id
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
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }
    
    .card-edit {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        overflow: hidden;
    }

    .card-header-edit {
        background: white;
        padding: 20px 25px;
        border-bottom: 2px solid #1e7256;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .preview-img {
        width: 150px;
        height: 150px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border: 3px solid #e9ecef;
        transition: transform 0.3s;
    }

    .preview-img:hover { transform: scale(1.05); }

    .btn-save {
        background: #1e7256;
        color: white;
        border-radius: 50px;
        padding: 10px 30px;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 10px rgba(30, 114, 86, 0.2);
        transition: all 0.2s;
    }

    .btn-save:hover { background: #165c45; transform: translateY(-2px); color: white; }

    .btn-back {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 500;
    }

    .form-floating > .form-control:focus,
    .form-floating > .form-select:focus {
        border-color: #1e7256;
        box-shadow: 0 0 0 0.25rem rgba(30, 114, 86, 0.15);
    }
</style>

<div class="container-fluid p-4">
    <div class="card card-edit">
        <div class="card-header-edit">
            <div>
                <h4 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-pencil-square me-2 text-success"></i>Edit Barang
                </h4>
                <small class="text-muted">Perbarui informasi data barang</small>
            </div>
            <a href="barang.php" class="btn btn-outline-secondary btn-back">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <form action="../proses/edit_barang.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_barang" value="<?= $data['id_barang']; ?>">
            <input type="hidden" name="foto_lama" value="<?= $data['foto']; ?>">

            <div class="card-body p-4">

                <?php if(isset($_GET['pesan'])): ?>
                    <?php if($_GET['pesan'] == 'sukses'): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>Data barang berhasil diperbarui!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php elseif($_GET['pesan'] == 'gagal'): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i>Gagal memperbarui data!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="row g-4">
                    <!-- Kolom Kiri: Form -->
                    <div class="col-md-8">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-3">Informasi Barang</label>
                        
                        <div class="form-floating mb-3">
                            <input type="text" name="nama_barang" class="form-control rounded-3" id="namaBrg" 
                                   value="<?= htmlspecialchars($data['nama_barang']); ?>" placeholder="Nama Barang" required>
                            <label for="namaBrg">Nama Barang</label>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="id_kategori" class="form-select rounded-3" id="kat" required>
                                        <option value="">Pilih...</option>
                                        <?php
                                        $kat = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                                        while ($k = mysqli_fetch_assoc($kat)) { 
                                            $selected = ($k['id_kategori'] == $data['id_kategori']) ? 'selected' : '';
                                            echo "<option value='{$k['id_kategori']}' $selected>{$k['nama_kategori']}</option>"; 
                                        }
                                        ?>
                                    </select>
                                    <label for="kat">Kategori</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="satuan" class="form-control rounded-3" id="satuan" 
                                           value="<?= htmlspecialchars($data['satuan']); ?>" placeholder="Pcs/Box" required>
                                    <label for="satuan">Satuan</label>
                                </div>
                            </div>
                        </div>

                        <label class="form-label text-muted small fw-bold text-uppercase mb-2 mt-2">Stok Saat Ini</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-layers"></i></span>
                            <input type="number" name="stok" class="form-control border-start-0" 
                                   value="<?= $data['stok']; ?>" min="0" placeholder="Jumlah Stok">
                        </div>
                    </div>

                    <!-- Kolom Kanan: Foto -->
                    <div class="col-md-4">
                        <div class="card bg-light border-0 text-center p-4 rounded-3 h-100">
                            <label class="form-label small text-muted fw-bold text-uppercase mb-3">Foto Barang</label>
                            <div class="mb-3">
                                <img src="<?= $img_src; ?>" alt="Foto Barang" class="preview-img" id="previewImg">
                            </div>
                            <input type="file" name="foto" class="form-control form-control-sm" accept="image/*" 
                                   id="inputFoto" onchange="previewFile(this)">
                            <small class="text-muted mt-2 d-block">Kosongkan jika tidak ingin mengubah foto</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white border-top-0 p-4 text-end">
                <a href="barang.php" class="btn btn-light rounded-pill px-4 me-2">Batal</a>
                <button type="submit" name="update_barang" class="btn btn-save">
                    <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewFile(input) {
    const preview = document.getElementById('previewImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include '../layout/footer.php'; ?>
