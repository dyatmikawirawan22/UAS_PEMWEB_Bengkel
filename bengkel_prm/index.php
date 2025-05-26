
<?php
session_start();
include 'config/db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Bengkel Shell</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { color: #2c3e50; }
        .menu { margin-top: 20px; }
        .menu a {
            display: inline-block;
            margin: 10px;
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .menu a:hover { background-color: #2980b9; }
    </style>
</head>
<body>

<h1>Selamat Datang di Aplikasi Bengkel Shell</h1>
<p>Silakan pilih menu berikut untuk melanjutkan:</p>

<div class="menu">
    <a href="pages/booking.php">Booking Servis</a>
    <a href="pages/riwayat.php">Riwayat Servis</a>
    <a href="pages/produk.php">Produk Part</a>
    <a href="pages/chat.php">Live Chat</a>
    <a href="login/login.php">Login</a>
</div>

</body>
</html>
