<?php 
include '../layout/header.php'; 
include '../layout/sidebar.php'; 
include '../config/koneksi.php';

// Semua user (admin, petugas, pimpinan) disimpan di tabel 'pengguna'
$id_user = $_SESSION['id_pengguna'];
$stmt    = mysqli_prepare($koneksi, "SELECT * FROM pengguna WHERE id_pengguna = ?");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$query  = mysqli_stmt_get_result($stmt);
$data   = mysqli_fetch_assoc($query);
mysqli_stmt_close($stmt);
?>

<div class="container-fluid p-4">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-custom h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="user-avatar" style="width:64px;height:64px;border-radius:18px;">
                            <i class="bi bi-person-fill fs-2"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1"><?= htmlspecialchars($data['nama_lengkap']); ?></h4>
                            <span class="badge bg-success"><?= ucfirst($_SESSION['level']); ?></span>
                        </div>
                    </div>
                    <div class="small text-muted mb-1">Username</div>
                    <div class="fw-semibold mb-3"><?= htmlspecialchars($data['username']); ?></div>
                    <div class="small text-muted mb-1">NIP</div>
                    <div class="fw-semibold"><?= isset($data['nip']) ? htmlspecialchars($data['nip']) : '-'; ?></div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">Pengaturan Profil</h4>
                        <small class="text-muted">Perbarui identitas akun dan password</small>
                    </div>
                </div>

                <form action="../proses/profile_proses.php" method="POST">
                    <div class="card-body p-4">
                        <?php if(isset($_GET['pesan'])): ?>
                            <?php if($_GET['pesan'] == 'sukses'): ?>
                                <div class="alert alert-success">Profil berhasil diperbarui!</div>
                            <?php elseif($_GET['pesan'] == 'gagal'): ?>
                                <div class="alert alert-danger">Gagal memperbarui profil.</div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="nama_lengkap" class="form-control" id="namaLengkap" value="<?= htmlspecialchars($data['nama_lengkap']); ?>" placeholder="Nama Lengkap" required>
                                    <label for="namaLengkap">Nama Lengkap</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-light" id="nip" value="<?= isset($data['nip']) ? htmlspecialchars($data['nip']) : '-'; ?>" placeholder="NIP" disabled>
                                    <label for="nip">NIP</label>
                                </div>
                                <small class="text-muted fst-italic">Hubungi Admin jika ingin mengubah NIP.</small>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="username" class="form-control" id="username" value="<?= htmlspecialchars($data['username']); ?>" placeholder="Username" required>
                                    <label for="username">Username</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" name="password_baru" class="form-control" id="passwordBaru" placeholder="Password Baru">
                                    <label for="passwordBaru">Password Baru</label>
                                </div>
                                <small class="text-muted">Kosongkan jika password tidak ingin diubah.</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white text-end p-4">
                        <button type="submit" name="update_profil" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>
