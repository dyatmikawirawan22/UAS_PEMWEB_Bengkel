<?php
$host = "localhost";       // atau 127.0.0.1
$user = "punjungr_bengkel";            // username default XAMPP
$password = "bengkel123...";            // kosongkan jika tidak ada password
$database = "punjungr_bengkel_sistem"; // nama database

// Buat koneksi
$conn = mysqli_connect("localhost", "punjungr_bengkel", "bengkel123...", "punjungr_bengkel_sistem");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
