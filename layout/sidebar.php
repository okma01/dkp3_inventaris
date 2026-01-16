<div class="sidebar">
    
    <div class="sidebar-profile">
        <?php 
            $logo_path = 'assets/logo.png'; // Path jika di root
            if(file_exists('../assets/logo.png')) { $logo_path = '../assets/logo.png'; }
        ?>
        <img src="<?= $logo_path ?>" alt="Logo" width="60" class="mb-3">
        <h5 class="mb-0 fw-bold">DKP3 Inventaris</h5>
    </div>

    <div class="mt-2">
        <small class="text-white-50 px-4 text-uppercase" style="font-size: 11px; letter-spacing: 1px;">Menu Utama</small>
        
        <a href="<?= $base_url ?>index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
            <i class="bi bi-grid-fill me-2"></i> Dashboard
        </a>
        
        <a href="<?= $base_url ?>pages/barang.php" class="<?= basename($_SERVER['PHP_SELF']) == 'barang.php' ? 'active' : '' ?>">
            <i class="bi bi-box-seam-fill me-2"></i> Data Barang
        </a>

        <small class="text-white-50 px-4 mt-4 d-block text-uppercase" style="font-size: 11px; letter-spacing: 1px;">Transaksi</small>

        <a href="<?= $base_url ?>pages/barang_masuk.php" class="<?= basename($_SERVER['PHP_SELF']) == 'barang_masuk.php' ? 'active' : '' ?>">
            <i class="bi bi-arrow-down-circle-fill me-2"></i> Barang Masuk
        </a>
        
        <a href="<?= $base_url ?>pages/barang_keluar.php" class="<?= basename($_SERVER['PHP_SELF']) == 'barang_keluar.php' ? 'active' : '' ?>">
            <i class="bi bi-arrow-up-circle-fill me-2"></i> Barang Keluar
        </a>

        <small class="text-white-50 px-4 mt-4 d-block text-uppercase" style="font-size: 11px; letter-spacing: 1px;">Lainnya</small>

        <a href="<?= $base_url ?>pages/laporan.php" class="<?= basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-text-fill me-2"></i>Laporan
        </a>
        <a href="<?= $base_url ?>pages/riwayat.php" 
        class="<?= basename($_SERVER['PHP_SELF']) == 'riwayat.php' ? '' : '' ?>">
            <i class="bi bi-clock-history me-2"></i> Riwayat
        </a>
        
        <div style="margin-top: 50px;">
            <a href="<?= $base_url ?>proses/logout.php" class="text-danger mt-4" onclick="return confirm('Yakin ingin keluar?')">
                <i class="bi bi-power me-2"></i> Logout
            </a>
        </div>
    </div>
</div>

<div class="content flex-grow-1">
    
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 p-3">
        <div class="container-fluid">
            <button class="btn btn-light border shadow-sm text-primary" id="menu-toggle">
                <i class="bi bi-list fs-5"></i>
            </button> 
            <!-- Profil Admin -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                id="dropdownUser"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                    <!-- Icon Profil -->
                    <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center"
                        style="width:42px;height:42px;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>
                </a>

                <!-- Popup / Dropdown -->
                <ul class="dropdown-menu dropdown-menu-end shadow p-3"
                    aria-labelledby="dropdownUser"
                    style="min-width: 260px; border-radius: 12px;">

                    <li class="text-center mb-2">
                        <strong><?= $_SESSION['nama_admin']; ?></strong><br>
                        <small class="text-muted">NIP: <?= $_SESSION['nip']; ?></small>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item py-2" href="<?= $base_url ?>pages/profile.php">
                            <i class="bi bi-person-gear me-2 text-primary"></i> Edit Profil
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item py-2 text-danger" href="<?= $base_url ?>proses/logout.php" onclick="return confirm('Yakin ingin logout?')">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>