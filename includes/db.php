<?php
$host = "localhost";       // atau 127.0.0.1
$user = "root";            // username default XAMPP
$password = "";            // kosongkan jika tidak ada password
$database = "bengkel_sistem"; // nama database

// Buat koneksi
$conn = mysqli_connect("localhost", "root", "", "bengkel_sistem");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
