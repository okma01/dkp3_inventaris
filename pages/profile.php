<?php 
include '../layout/header.php'; 
include '../layout/sidebar.php'; 
include '../config/koneksi.php';

$id_admin = $_SESSION['id_admin']; // Pastikan ID tersimpan di session saat login
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '$id_admin'");
$data = mysqli_fetch_assoc($query);
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Pengaturan Profil</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h3 class="card-title">Edit Username & Password</h3>
                        </div>
                        <form action="../proses/profile_proses.php" method="POST">
                            <div class="card-body">
                                <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'sukses'): ?>
                                    <div class="alert alert-success">Profil berhasil diperbarui!</div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control" value="<?= $data['nama_lengkap'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control" value="<?= $data['nip'] ?>" disabled>
                                    <small class="text-muted text-italic">*NIP tidak dapat diubah</small>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" name="password_baru" class="form-control" placeholder="Kosongkan jika tidak ingin ganti">
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../layout/footer.php'; ?>