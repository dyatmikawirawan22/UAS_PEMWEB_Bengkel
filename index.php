<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Punjung Rejeki Motor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .auth-buttons {
            margin-bottom: 20px;
        }
        .auth-buttons a {
            display: inline-block;
            padding: 10px 15px;
            margin-right: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .auth-buttons a:hover {
            background-color: #0056b3;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
        ul li a {
            text-decoration: none;
            color: #333;
        }
        ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Selamat Datang di Punjung Rejeki Motor</h1>

<div class="auth-buttons">
    <?php if (isset($_SESSION['id_user'])): ?>
        <span>Halo, <strong><?= htmlspecialchars($_SESSION['nama_user']) ?></strong>!</span>
        <a href="auth/logout.php">Logout</a>
    <?php else: ?>
        <a href="auth/login.php">Login</a>
        <a href="auth/register.php">Daftar</a>
    <?php endif; ?>
</div>

<h3>Fitur Kami</h3>
<ul>
    <li><a href="booking.php">🛠 Booking Servis</a></li>
    <li><a href="estimasi.php">💰 Estimasi Biaya Servis</a></li>
    <li><a href="riwayat.php">📋 Riwayat Servis</a></li>
    <li><a href="produk.php">🧩 Cek Produk Part</a></li>
    <li><a href="chat.php">💬 Live Chat</a></li>
</ul>

</body>
</html>