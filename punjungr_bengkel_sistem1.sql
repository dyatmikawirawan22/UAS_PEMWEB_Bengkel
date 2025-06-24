-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 24 Jun 2025 pada 21.18
-- Versi server: 8.0.34
-- Versi PHP: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `punjungr_bengkel_sistem`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id_booking` int NOT NULL,
  `id_user` int NOT NULL,
  `jenis_kendaraan_booking` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipe_kendaraan_booking` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nopol_booking` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tahun_booking` year NOT NULL,
  `jenis_servis_booking` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keluhan_booking` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tanggal_booking` date NOT NULL,
  `waktu_booking` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_booking` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Menunggu Konfirmasi',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id_booking`, `id_user`, `jenis_kendaraan_booking`, `tipe_kendaraan_booking`, `nopol_booking`, `tahun_booking`, `jenis_servis_booking`, `keluhan_booking`, `tanggal_booking`, `waktu_booking`, `status_booking`, `created_at`) VALUES
(10, 20, 'Motor', 'Mio', 'A 1234 BC', '2025', 'Servis Ringan', 'TOLONG', '2025-06-16', '15:00-17:00', 'Batal', '2025-06-14 14:53:03'),
(11, 23, 'Motor', 'honda porsche', 'L 015 PCX', '2005', 'Servis Besar', 'motor gabisa jalan', '2025-06-26', '13:00-15:00', 'Selesai', '2025-06-15 11:21:49'),
(12, 26, 'Motor', 'CBR 250', 'AG 0202 AH', '2017', 'Servis Berkala', 'ganti oli', '2025-06-18', '10:00-12:00', 'Dikonfirmasi', '2025-06-15 15:30:05'),
(13, 20, 'Motor', 'Mio', 'AG 1945 INA', '2015', 'Perbaikan', 'MOHON', '2025-06-21', '15:00-17:00', 'Dikonfirmasi', '2025-06-19 05:45:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id_chat` int NOT NULL,
  `id_pengirim` int DEFAULT NULL,
  `id_penerima` int DEFAULT NULL,
  `isi_pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `waktu_kirim` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `chat_messages`
--

INSERT INTO `chat_messages` (`id_chat`, `id_pengirim`, `id_penerima`, `isi_pesan`, `waktu_kirim`) VALUES
(1, 22, 20, 'halo', '2025-06-15 14:32:56'),
(2, 20, 22, 'woi', '2025-06-15 14:33:14'),
(3, 20, 22, 'saya mau beli bakso', '2025-06-15 14:33:21'),
(4, 22, 20, 'ok', '2025-06-15 14:33:44'),
(5, 22, 20, 'hahaha', '2025-06-15 14:34:22'),
(6, 20, 22, 'anj', '2025-06-15 14:34:52'),
(7, 20, 22, 'ppp', '2025-06-15 18:18:03'),
(8, 23, 22, 'p', '2025-06-15 18:18:23'),
(9, 23, 22, 'bang', '2025-06-15 18:18:25'),
(10, 23, 22, 'kok gabisa ?', '2025-06-15 18:18:31'),
(11, 23, 22, 'cara upload ?', '2025-06-15 18:18:35'),
(12, 23, 22, 'p', '2025-06-15 18:18:37'),
(13, 23, 22, 'p', '2025-06-15 18:18:38'),
(14, 23, 22, 'p', '2025-06-15 18:18:38'),
(15, 23, 22, 'p', '2025-06-15 18:18:39'),
(16, 23, 22, 'p', '2025-06-15 18:18:39'),
(17, 23, 22, 'p', '2025-06-15 18:18:40'),
(18, 23, 22, 'p', '2025-06-15 18:18:40'),
(19, 23, 22, 'p', '2025-06-15 18:18:41'),
(20, 23, 22, 'p', '2025-06-15 18:18:41'),
(21, 24, 22, 'hi', '2025-06-15 18:19:00'),
(22, 20, 22, 'asa', '2025-06-15 18:19:28'),
(23, 22, 20, 'ya', '2025-06-15 18:19:30'),
(24, 22, 23, 'ya', '2025-06-15 18:19:39'),
(25, 22, 20, 'halo sasa', '2025-06-15 18:47:45'),
(26, 20, 22, 'ada', '2025-06-15 18:58:00'),
(27, 22, 23, 'ok', '2025-06-15 18:58:09'),
(28, 25, 22, 'Halo mas', '2025-06-15 20:19:33'),
(29, 25, 22, 'Saya mau service motor vario jam 7 pagi besok yaa, terimakasih', '2025-06-15 20:20:16'),
(30, 22, 25, 'oke siapp', '2025-06-15 20:20:31'),
(31, 24, 22, 'saya pesan bakso dan mie ayam karbu dengan topping oli shell', '2025-06-15 20:21:39'),
(32, 26, 22, 'halo', '2025-06-15 22:26:58'),
(33, 22, 26, 'haloo kak cantik', '2025-06-15 22:27:14'),
(34, 26, 22, 'y', '2025-06-15 22:27:19'),
(35, 26, 22, 'jgn godain saya masl', '2025-06-15 22:27:33'),
(36, 26, 22, 'kak', '2025-06-15 22:32:48'),
(37, 26, 22, 'beliin saya motor', '2025-06-15 22:32:56'),
(38, 23, 22, 'pak infoooo', '2025-06-16 12:57:33'),
(39, 23, 22, 'pak infoooo', '2025-06-16 12:57:34'),
(40, 22, 26, 'chat macam apa ini', '2025-06-16 21:24:34'),
(41, 22, 20, 'motor anda meledak', '2025-06-19 13:12:15'),
(42, 20, 22, 'LOH', '2025-06-19 13:12:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `estimasi_servis`
--

CREATE TABLE `estimasi_servis` (
  `id_estimasi` int NOT NULL,
  `jenis_servis_estimasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estimasi_waktu_estimasi` int DEFAULT NULL,
  `tarif_per_jam_estimasi` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int NOT NULL,
  `nama_produk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori_produk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stok_produk` int DEFAULT NULL,
  `harga_produk` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `kategori_produk`, `stok_produk`, `harga_produk`) VALUES
(10, 'Motul 5400V', 'OLI', 3, 50000.00),
(12, 'Federal Matic 30 Ecomaxx', 'OLI', 0, 55000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_servis`
--

CREATE TABLE `riwayat_servis` (
  `id_riwayat` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `tanggal_riwayat` date DEFAULT NULL,
  `jenis_kendaraan_riwayat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keluhan_riwayat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tindakan_riwayat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `spare_part_riwayat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `biaya_riwayat` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role_user` enum('pelanggan','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pelanggan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `email_user`, `password_user`, `role_user`) VALUES
(20, 'pelanggan1', 'pelanggan1@gmail.com', '$2y$10$3dAzKVLecGLkQMPRbbV0..V7voVzX913tXi6bdC0mASI13vTWZIBe', 'pelanggan'),
(22, 'admin1', 'admin1@gmail.com', '$2y$10$FtNu0wzQWpegHcUigImAOuiVtj6Tmm05rCSVpAgldhfAxGTPtAfNG', 'admin'),
(23, 'lois', 'lois@gmail.com', '$2y$10$y70oxBgiGgYzgPUZc./jS.PYPBPZABwfNP7qCB.il/QCtr.mnu3ve', 'pelanggan'),
(24, 'pelanggan2', 'pelanggan2@gmail.com', '$2y$10$ef.Efzmz6RdtRWFr9ufgJOm13xoLFmRpuTD8Wtit02OLH79AjX.oS', 'pelanggan'),
(25, 'ari', 'ari@gmail.com', '$2y$10$yF7UynRPiTwHRxty21hr0OhtOWdbTgR2/861q7GpaRNQ/4rGOa0ii', 'pelanggan'),
(26, 'revalina', 'revacomelbanget@gmail.com', '$2y$10$n0DX5dixpjDLv9jHBR0l.ezEbbwlpsaSzZXESI5gYj8GQlzLzp5XK', 'pelanggan'),
(27, 'wira@gmail.com', 'wira@gmail.com', '$2y$10$kGbnZtopvqR5qAVq98Rrc.xNn64Z.QCKSHJPPKuUAVzaQlud224TC', 'pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id_chat`);

--
-- Indeks untuk tabel `estimasi_servis`
--
ALTER TABLE `estimasi_servis`
  ADD PRIMARY KEY (`id_estimasi`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `riwayat_servis`
--
ALTER TABLE `riwayat_servis`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email_user` (`email_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id_booking` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id_chat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `estimasi_servis`
--
ALTER TABLE `estimasi_servis`
  MODIFY `id_estimasi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `riwayat_servis`
--
ALTER TABLE `riwayat_servis`
  MODIFY `id_riwayat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `riwayat_servis`
--
ALTER TABLE `riwayat_servis`
  ADD CONSTRAINT `riwayat_servis_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
