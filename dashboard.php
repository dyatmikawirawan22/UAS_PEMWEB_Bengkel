<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

$nama = $_SESSION['nama_user'];
$role = $_SESSION['role_user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Punjung Rejeki Motor</title>
</head>
<body>
    <h2>Selamat datang, <?= htmlspecialchars($nama); ?>!</h2>
    <p>Role: <strong><?= $role; ?></strong></p>

    <?php if ($role == 'admin') : ?>
        <h3>Menu Admin</h3>
        <ul>
            <li><a href="admin/data_booking.php">Kelola Booking</a></li>
            <li><a href="admin/produk_part.php">Kelola Produk Part</a></li>
            <li><a href="admin/riwayat_servis.php">Riwayat Servis</a></li>
        </ul>
    <?php else : ?>
        <h3>Menu Pelanggan</h3>
        <ul>
            <li><a href="booking.php">Booking Servis</a></li>
            <li><a href="riwayat.php">Riwayat Servis</a></li>
            <li><a href="estimasi.php">Cek Estimasi Biaya</a></li>
        </ul>
    <?php endif; ?>

    <br>
    <a href="auth/logout.php">Logout</a>
</body>
</html>
