<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['nama_user'])) {
    header("Location: login.php?pesan=Silahkan login terlebih dahulu");
    exit();
}

// Koneksi ke database (sesuaikan dengan konfigurasi Anda)
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'bengkel_motor';
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama_pemilik = $_SESSION['nama_user'];
$merk = $conn->real_escape_string($_POST['merk']);
$tipe = $conn->real_escape_string($_POST['tipe']);
$nopol = $conn->real_escape_string($_POST['nopol']);
$tahun = $conn->real_escape_string($_POST['tahun']);
$jenis_servis = $conn->real_escape_string($_POST['jenis_servis']);
$keluhan = $conn->real_escape_string($_POST['keluhan']);
$tanggal = $conn->real_escape_string($_POST['tanggal']);
$waktu = $conn->real_escape_string($_POST['waktu']);

// Generate nomor booking
$no_booking = 'PRM-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

// Simpan ke database
$sql = "INSERT INTO bookings (no_booking, nama_pemilik, merk, tipe, nopol, tahun, jenis_servis, keluhan, tanggal, waktu, status) 
        VALUES ('$no_booking', '$nama_pemilik', '$merk', '$tipe', '$nopol', '$tahun', '$jenis_servis', '$keluhan', '$tanggal', '$waktu', 'Menunggu Konfirmasi')";

if ($conn->query($sql) === TRUE) {
    // Jika berhasil disimpan
    header("Location: index.php?pesan=Booking berhasil! Nomor booking Anda: $no_booking");
} else {
    // Jika gagal
    header("Location: form_booking.php?pesan=Gagal melakukan booking. Silahkan coba lagi.");
}

$conn->close();
?>
