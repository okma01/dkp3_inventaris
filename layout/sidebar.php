<div class="sidebar">
    
    <div class="sidebar-profile">
        <?php 
            $logo_path = 'assets/logo.png'; // Path jika di root
            if(file_exists('../assets/logo.png')) { $logo_path = '../assets/logo.png'; }
        ?>
        <img src="<?= $logo_path ?>" alt="Logo" width="60" class="mb-3 bg-white rounded-circle p-1">
        
        <h5 class="mb-0 fw-bold">DKP3 Inventaris</h5>
        <small class="text-white-50">
            Halo, <?= isset($_SESSION['nama']) ? explode(' ', $_SESSION['nama'])[0] : 'Admin'; ?>!
        </small>
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
            <i class="bi bi-file-earmark-text-fill me-2"></i> Pusat Laporan
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

            <span class="navbar-text ms-auto text-dark">
                <i class="bi bi-calendar-check me-1"></i> <?= date('d F Y'); ?>
            </span>
        </div>
    </nav>