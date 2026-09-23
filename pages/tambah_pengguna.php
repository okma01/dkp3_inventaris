<?php
require_once __DIR__ . '/../config/auth.php';
dkp_require_roles(['admin']);

include '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama     = $_POST['nama_lengkap'];
    $nip      = $_POST['nip'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $level    = $_POST['level'];

    $result = mysqli_query($koneksi, "
        INSERT INTO pengguna (nama_lengkap, nip, username, password, level)
        VALUES ('$nama', '$nip', '$username', '$password', '$level')
    ");

    if ($result) {
        // Catat ke riwayat: siapa (admin) menambahkan pengguna siapa
        $nama_admin = isset($_SESSION['nama_admin']) ? mysqli_real_escape_string($koneksi, $_SESSION['nama_admin']) : '';
        $nip_admin  = isset($_SESSION['nip']) ? mysqli_real_escape_string($koneksi, $_SESSION['nip']) : '';
        $nama_pengguna_baru = mysqli_real_escape_string($koneksi, $nama);
        $today = date('Y-m-d H:i:s');

        mysqli_query($koneksi, "INSERT INTO riwayat_barang (nama_user, nip, nama_barang, jenis_aktivitas, jumlah, tanggal) 
                                 VALUES ('$nama_admin', '$nip_admin', '$nama_pengguna_baru', 'tambah_pengguna', 1, '$today')");
    }

    header("Location: daftar_pengguna.php");
}
?>
<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar.php'; ?>

<div class="container-fluid p-4">
    <div class="card card-custom">
        <div class="card-header-dark">
            <div>
                <h4 class="mb-0 fw-bold text-dark">Tambah Pengguna</h4>
                <small class="text-muted">Buat akun baru untuk akses sistem inventaris</small>
            </div>
            <a href="daftar_pengguna.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <form method="post">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="nama_lengkap" class="form-control" id="namaLengkap" placeholder="Nama Lengkap" required>
                            <label for="namaLengkap">Nama Lengkap</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="nip" class="form-control" id="nip" placeholder="NIP" required>
                            <label for="nip">NIP</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                            <label for="username">Username</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="level" class="form-select" id="level" required>
                                <option value="">Pilih Level</option>
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                                <option value="pimpinan">Pimpinan</option>
                            </select>
                            <label for="level">Level Akses</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white text-end p-4">
                <a href="daftar_pengguna.php" class="btn btn-light px-4 me-2">Batal</a>
                <button type="submit" name="simpan" class="btn btn-success px-4">
                    <i class="bi bi-check-lg me-1"></i>Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../layout/footer.php'; ?>
