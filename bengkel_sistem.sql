-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 06:58 AM
-- Server version: 8.4.5
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bengkel_sistem`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id_booking` int NOT NULL,
  `id_user` int NOT NULL,
  `jenis_kendaraan_booking` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tipe_kendaraan_booking` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nopol_booking` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tahun_booking` year NOT NULL,
  `jenis_servis_booking` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `keluhan_booking` text COLLATE utf8mb4_general_ci,
  `tanggal_booking` date NOT NULL,
  `waktu_booking` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `status_booking` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'Menunggu Konfirmasi',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id_chat` int NOT NULL,
  `pengirim_chat` int DEFAULT NULL,
  `penerima_chat` int DEFAULT NULL,
  `pesan_chat` text COLLATE utf8mb4_general_ci,
  `waktu_chat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_chat` enum('terbaca','baru') COLLATE utf8mb4_general_ci DEFAULT 'baru'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimasi_servis`
--

CREATE TABLE `estimasi_servis` (
  `id_estimasi` int NOT NULL,
  `jenis_servis_estimasi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estimasi_waktu_estimasi` int DEFAULT NULL,
  `tarif_per_jam_estimasi` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int NOT NULL,
  `nama_produk` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori_produk` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stok_produk` int DEFAULT NULL,
  `harga_produk` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_servis`
--

CREATE TABLE `riwayat_servis` (
  `id_riwayat` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `tanggal_riwayat` date DEFAULT NULL,
  `jenis_kendaraan_riwayat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keluhan_riwayat` text COLLATE utf8mb4_general_ci,
  `tindakan_riwayat` text COLLATE utf8mb4_general_ci,
  `spare_part_riwayat` text COLLATE utf8mb4_general_ci,
  `biaya_riwayat` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama_user` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_user` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_user` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role_user` enum('pelanggan','admin') COLLATE utf8mb4_general_ci DEFAULT 'pelanggan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `pengirim_chat` (`pengirim_chat`),
  ADD KEY `penerima_chat` (`penerima_chat`);

--
-- Indexes for table `estimasi_servis`
--
ALTER TABLE `estimasi_servis`
  ADD PRIMARY KEY (`id_estimasi`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `riwayat_servis`
--
ALTER TABLE `riwayat_servis`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email_user` (`email_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id_booking` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimasi_servis`
--
ALTER TABLE `estimasi_servis`
  MODIFY `id_estimasi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_servis`
--
ALTER TABLE `riwayat_servis`
  MODIFY `id_riwayat` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`pengirim_chat`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`penerima_chat`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `riwayat_servis`
--
ALTER TABLE `riwayat_servis`
  ADD CONSTRAINT `riwayat_servis_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
