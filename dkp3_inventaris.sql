-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 27, 2026 at 12:12 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dkp3_inventaris`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int NOT NULL,
  `id_kategori` int DEFAULT NULL,
  `nama_barang` varchar(150) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `stok` int DEFAULT '0',
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `id_kategori`, `nama_barang`, `satuan`, `stok`, `foto`) VALUES
(4, 2, 'Pensil 2B', 'Kotak', 35, 'barang_695d939591467.jpg'),
(5, 4, 'Printer ', 'box', 20, 'barang_696784eba401f.jpg'),
(6, 1, 'Kertas A4 Sidu', 'Rim', 40, 'barang_69686f51a49e5.jpg'),
(7, 1, 'A4 a1ne', 'Rim', 10, 'barang_69686fe5c0eb1.png'),
(8, 3, 'Map kertas', 'Pcs', 30, 'barang_69687042adb23.png'),
(10, 5, 'Kursi Kantor', 'Unit', 10, 'barang_69698ce7d979e.jpeg'),
(11, 2, 'Pulpen M&G Stick Gel Pen 0.38mm', 'box', 30, 'barang_69703ea018907.jpg'),
(12, 2, 'Spidol whiteboard', 'Pcs', 10, 'barang_69783429148a2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_keluar` int NOT NULL,
  `id_barang` int DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int NOT NULL,
  `penerima` varchar(100) NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_keluar`, `id_barang`, `tanggal`, `jumlah`, `penerima`, `keterangan`) VALUES
(4, 5, '2026-01-15', 5, 'BIdang Perikanan', ''),
(5, 6, '2026-01-15', 20, 'BIdang Perikanan', 'Untuk Print'),
(6, 7, '2026-01-16', 20, 'BIdang Perikanan', 'Kekurangan Kertas'),
(7, 10, '2026-01-20', 2, 'Bidang kafe', 'Kursi amat Rusak Minta Kursi Baru'),
(8, 4, '2026-01-20', 5, 'Bidang kafe', 'Kehabisan'),
(9, 7, '2026-01-20', 20, 'Bidang kafe', 'Buat printer');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_masuk` int NOT NULL,
  `id_barang` int DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int NOT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_masuk`, `id_barang`, `tanggal`, `jumlah`, `keterangan`) VALUES
(3, 4, '2026-01-14', 10, 'Untuk Pengadaan'),
(4, 5, '2026-01-16', 5, 'Penambahan Barang'),
(5, 6, '2026-01-20', 40, 'STOK TIPIS'),
(6, 4, '2026-01-20', 10, 'Cadangan'),
(7, 10, '2026-01-27', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Kertas'),
(2, 'Alat Tulis'),
(3, 'Map & File'),
(4, 'Elektronik'),
(5, 'Lain-lain');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `nip`, `username`, `password`, `level`) VALUES
(5, 'Abu Yajid Bustami, S.Sos, M.AP', '196607111987031005', 'Abuyajid01', '$2y$10$4ajWIugKyfqP/UZTQ7BT5ucUbXEL45qWCPbKWqL.jePma1SYwsLXS', 'pimpinan'),
(6, 'Noris', '123546338945785764', 'Noris01', '$2y$10$h8CqEjwx9Lufy4VlFypjaekmd.2LHkTQ/FbJocDqVc69/XaEBB40i', 'petugas'),
(7, 'budi Santoso', '8389236482', 'budi01', '$2y$10$eU5UbtdOzzVrHw7isV0rS.ejPFB/4SKbBNWbo3GPFVG5ir9XO6d1m', 'admin'),
(8, 'Rabiatul Adwiyah', '19760830 2007012102', 'admin', '$2y$10$fdUE.iv5VVN28PAMuzqUyOA3YZCft2uEhQvzPkST3yURf/kct0H5a', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_barang`
--

CREATE TABLE `riwayat_barang` (
  `id_riwayat` int NOT NULL,
  `nama_user` varchar(100) DEFAULT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `jenis_aktivitas` enum('masuk','keluar') DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `riwayat_barang`
--

INSERT INTO `riwayat_barang` (`id_riwayat`, `nama_user`, `nip`, `nama_barang`, `jenis_aktivitas`, `jumlah`, `tanggal`) VALUES
(1, 'Rabiatul Adwiyah', '19760830 2007012102', 'Kursi Kantor', 'masuk', 10, '2026-01-16 00:00:00'),
(2, 'Rabiatul Adwiyah', '19760830 2007012102', 'A4 a1ne', 'keluar', 20, '2026-01-16 00:00:00'),
(7, 'Noris', '123546338945785764', 'A4 a1ne', 'keluar', 20, '2026-01-20 00:00:00'),
(8, 'Rabiatul Adwiyah', '19760830 2007012102', 'Pulpen M&G Stick Gel Pen 0.38mm', 'masuk', 30, '2026-01-21 00:00:00'),
(9, 'budi Santoso', '8389236482', 'Spidol whiteboard', 'masuk', 10, '2026-01-27 00:00:00'),
(10, 'budi Santoso', '8389236482', 'Kursi Kantor', 'masuk', 2, '2026-01-27 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_keluar`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_masuk`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `riwayat_barang`
--
ALTER TABLE `riwayat_barang`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_keluar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_masuk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `riwayat_barang`
--
ALTER TABLE `riwayat_barang`
  MODIFY `id_riwayat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL;

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
