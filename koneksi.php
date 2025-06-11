<?php
$conn = mysqli_connect("localhost", "root", "", "bengkel_sistem");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}