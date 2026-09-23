<?php
// PENGATURAN PATH OTOMATIS
// Ini untuk mencegah error jika $base_url belum diset di file config/koneksi.php
// Jika file ini di-include dari folder 'pages', kita harus mundur satu langkah (../)
// Jika dari index.php utama, kita tidak perlu mundur.
$base_url = isset($base_url) ? $base_url : '../'; 

// Cek posisi file saat ini untuk menentukan 'active' state menu
$current_page = basename($_SERVER['PHP_SELF']);

$profile_name = htmlspecialchars($_SESSION['nama_admin'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8');
$profile_role = htmlspecialchars(ucfirst($_SESSION['level'] ?? 'Pengguna'), ENT_QUOTES, 'UTF-8');
$profile_nip  = htmlspecialchars($_SESSION['nip'] ?? '-', ENT_QUOTES, 'UTF-8');
?>

<div class="sidebar">
    
    <div class="sidebar-profile">
        <?php 
            $logo_path = 'assets/logo.png'; 
            // Cek apakah diakses dari folder pages atau root
            if(file_exists('../assets/logo.png')) { 
                $logo_path = '../assets/logo.png'; 
            }
        ?>
        <div class="d-flex align-items-center">
            <img src="<?= $logo_path ?>" alt="Logo">
            <div>
                <h5 class="mb-1 fw-bold">DKP3 Inventaris</h5>
                <div class="small">Manajemen stok ATK</div>
            </div>
        </div>
    </div>

    <div class="mt-2">
        <small class="sidebar-section-label">Menu Utama</small>
        
        <a href="<?= $base_url ?>index.php" class="<?= $current_page == 'index.php' || $current_page == 'index1.php' ? 'active' : '' ?>">
            <i class="bi bi-grid-fill me-2"></i> Dashboard
        </a>
        
        <a href="<?= $base_url ?>pages/barang.php" class="<?= $current_page == 'barang.php' ? 'active' : '' ?>">
            <i class="bi bi-box-seam-fill me-2"></i> Data Barang
        </a>

        <?php if($_SESSION['level'] == 'admin') : ?>
        <a href="<?= $base_url ?>pages/daftar_pengguna.php" class="<?= $current_page == 'daftar_pengguna.php' || $current_page == 'tambah_pengguna.php' ? 'active' : '' ?>">
            <i class="bi bi-people-fill me-2"></i> Data Pengguna
        </a>
        <?php endif; ?>

        <small class="sidebar-section-label">Transaksi</small>

        <a href="<?= $base_url ?>pages/barang_masuk.php" class="<?= $current_page == 'barang_masuk.php' ? 'active' : '' ?>">
            <i class="bi bi-arrow-down-circle-fill me-2"></i> Barang Masuk
        </a>
        
        <a href="<?= $base_url ?>pages/barang_keluar.php" class="<?= $current_page == 'barang_keluar.php' ? 'active' : '' ?>">
            <i class="bi bi-arrow-up-circle-fill me-2"></i> Barang Keluar
        </a>

        <small class="sidebar-section-label">Lainnya</small>
         
        <a href="<?= $base_url ?>pages/laporan.php" class="<?= $current_page == 'laporan.php' ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-text-fill me-2"></i> Laporan
        </a>

        <?php if($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'petugas') : ?>   
        <a href="<?= $base_url ?>pages/riwayat.php" class="<?= $current_page == 'riwayat.php' ? 'active' : '' ?>">
            <i class="bi bi-clock-history me-2"></i> Riwayat
        </a>
        <?php endif; ?>

        <div class="mt-4 pt-2">
            <a href="<?= $base_url ?>proses/logout.php" class="text-danger mt-4" onclick="return confirm('Yakin ingin keluar?')">
                <i class="bi bi-power me-2"></i> Logout
            </a>
        </div>
    </div>
</div>

<div class="content flex-grow-1">
    
    <nav class="navbar navbar-expand-lg navbar-light app-topbar mb-4 p-3">
        <div class="container-fluid">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light border shadow-sm text-primary" id="menu-toggle" type="button" aria-label="Toggle menu">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="topbar-title">
                    <strong>Inventaris ATK DKP3</strong>
                    <span><?= date('l, d F Y'); ?></span>
                </div>
            </div>

            <div class="dropdown profile-dropdown">
                <button class="topbar-profile-trigger dropdown-toggle"
                        id="dropdownUser"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        aria-label="Buka menu akun <?= $profile_name; ?>">
                    <span class="topbar-profile-copy d-none d-md-block">
                        <small>Akun aktif</small>
                        <strong><?= $profile_name; ?></strong>
                    </span>

                    <span class="user-avatar" aria-hidden="true">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    <i class="bi bi-chevron-down profile-trigger-chevron" aria-hidden="true"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end profile-menu"
                    aria-labelledby="dropdownUser">
                    <li class="profile-menu-summary">
                        <span class="profile-menu-avatar" aria-hidden="true">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <span class="profile-menu-identity">
                            <strong><?= $profile_name; ?></strong>
                            <span class="profile-menu-role"><?= $profile_role; ?></span>
                            <small><i class="bi bi-person-vcard"></i>NIP <?= $profile_nip; ?></small>
                        </span>
                    </li>

                    <li class="profile-menu-actions">
                        <a class="dropdown-item profile-menu-item" href="<?= $base_url ?>pages/profile.php">
                            <span class="profile-menu-icon"><i class="bi bi-person-gear"></i></span>
                            <span>
                                <strong>Edit Profil</strong>
                                <small>Ubah identitas dan password</small>
                            </span>
                            <i class="bi bi-chevron-right profile-menu-arrow" aria-hidden="true"></i>
                        </a>

                        <a class="dropdown-item profile-menu-item profile-menu-logout" href="<?= $base_url ?>proses/logout.php" onclick="return confirm('Yakin ingin logout?')">
                            <span class="profile-menu-icon"><i class="bi bi-box-arrow-right"></i></span>
                            <span>
                                <strong>Logout</strong>
                                <small>Keluar dari aplikasi</small>
                            </span>
                            <i class="bi bi-chevron-right profile-menu-arrow" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
