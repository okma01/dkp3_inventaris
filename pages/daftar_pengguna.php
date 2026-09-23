<?php
require_once __DIR__ . '/../config/auth.php';
dkp_require_roles(['admin']);
include '../layout/header.php';
?>
<?php include '../layout/sidebar.php'; ?>

<style>
    body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }
    .card-custom { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; }
    .card-header-dark {
        background: white; padding: 20px 25px; border-bottom: 2px solid #343a40; /* Dark border */
        display: flex; justify-content: space-between; align-items: center;
    }
    .table-custom thead th { background-color: #f8f9fa; color: #495057; border: none; padding: 15px; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; }
    .table-custom tbody td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #f9f9f9; }
    .btn-add-dark {
        background: #343a40; color: white; border-radius: 50px; padding: 10px 25px; border: none; box-shadow: 0 4px 10px rgba(52, 58, 64, 0.2); transition: 0.2s;
    }
    .btn-add-dark:hover { background: #23272b; transform: translateY(-2px); color: white; }
    .badge-role { padding: 6px 12px; border-radius: 6px; font-weight: 500; font-size: 0.8rem; text-transform: capitalize; }
    .role-admin { background: #e0e7ff; color: #4338ca; }
    .role-petugas { background: #dcfce7; color: #15803d; }
    .role-pimpinan { background: #ffedd5; color: #c2410c; }
</style>

<div class="container-fluid p-4">
    <div class="card card-custom">
        <div class="card-header-dark">
            <div>
                <h4 class="mb-0 fw-bold text-dark">Manajemen Pengguna</h4>
                <small class="text-muted">Kelola akses akun sistem</small>
            </div>
            <a href="tambah_pengguna.php" class="btn-add-dark text-decoration-none">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah Pengguna
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom mb-0 table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>NIP</th>
                            <th>Username</th>
                            <th class="text-center">Level</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../config/koneksi.php';
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM pengguna ORDER BY level ASC, nama_lengkap ASC");
                        while ($row = mysqli_fetch_assoc($query)) {
                            // Tentukan warna badge berdasarkan level
                            $badgeClass = 'bg-light text-dark';
                            if($row['level'] == 'admin') $badgeClass = 'role-admin';
                            elseif($row['level'] == 'petugas') $badgeClass = 'role-petugas';
                            elseif($row['level'] == 'pimpinan') $badgeClass = 'role-pimpinan';
                        ?>
                        <tr>
                            <td class="text-center text-muted"><?= $no++; ?></td>
                            <td class="fw-medium">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary" style="width:35px;height:35px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <?= $row['nama_lengkap']; ?>
                                </div>
                            </td>
                            <td class="text-muted"><?= isset($row['nip']) ? $row['nip'] : '-'; ?></td>
                            <td class="text-primary"><?= $row['username']; ?></td>
                            <td class="text-center">
                                <span class="badge badge-role <?= $badgeClass; ?>">
                                    <?= $row['level']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="../proses/hapus_pengguna.php?id=<?= $row['id_pengguna']; ?>" 
                                   class="btn btn-sm btn-light text-danger rounded-circle shadow-sm"
                                   style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;"
                                   onclick="return confirm('PERINGATAN: Menghapus pengguna ini akan menghilangkan akses login mereka.\n\nLanjutkan?')"
                                   title="Hapus Akun">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>
