<?php
session_start();
include '../../includes/db.php'; // Pastikan path-nya sesuai

if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php?pesan=Silakan login terlebih dahulu");
    exit();
}

$id_user = $_SESSION['id_user'];
$jenis_kendaraan = $_POST['jenis_kendaraan'];
$tipe = $_POST['tipe'];
$nopol = $_POST['nopol'];
$tahun = $_POST['tahun'];
$jenis_servis = $_POST['jenis_servis'];
$keluhan = $_POST['keluhan'];
$tanggal = $_POST['tanggal'];
$waktu = $_POST['waktu'];

// Set status default booking
$status = 'Menunggu Konfirmasi';

$query = mysqli_query($conn, "INSERT INTO bookings 
    (id_user, jenis_kendaraan_booking, tipe_kendaraan_booking, nopol_booking, tahun_booking, jenis_servis_booking, keluhan_booking, tanggal_booking, waktu_booking, status_booking)
    VALUES 
    ('$id_user', '$jenis_kendaraan', '$tipe', '$nopol', '$tahun', '$jenis_servis', '$keluhan', '$tanggal', '$waktu', '$status')");

if ($query) {
    header("Location: ../../index.php?pesan=Booking berhasil");
    exit();
} else {
    echo "Gagal melakukan booking: " . mysqli_error($conn);
}
?>
