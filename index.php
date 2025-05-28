<?php
session_start();
$nama_user = isset($_SESSION['nama_user']) ? $_SESSION['nama_user'] : null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Punjung Rejeki Motor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        header {
            background: #2c3e50;
            color: white;
            padding: 20px 0;
        }
        nav {
            margin: 20px 0;
        }
        .menu a {
            display: inline-block;
            margin: 10px 15px;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
        .menu a:hover {
            background: #2980b9;
        }
        .auth-buttons {
            margin-top: 20px;
        }
        .auth-buttons a {
            margin: 0 10px;
            padding: 8px 16px;
            background: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .auth-buttons a.logout {
            background: #e74c3c;
        }
        .pesan {
            color: green;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<header>
    <h1>PUNJUNG REJEKI MOTOR</h1>
    <p>Layanan Servis Motor & Spare Part Terpercaya!</p>
</header>

<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'logout'): ?>
    <p class="pesan">Anda berhasil logout.</p>
<?php endif; ?>

<?php if ($nama_user): ?>
    <p>Halo, <strong><?= htmlspecialchars($nama_user) ?></strong>!</p>
<?php endif; ?>

<nav class="menu">
    <a href="#">Booking Service</a>
    <a href="#">Estimasi Biaya</a>
    <a href="#">Product Spare Part</a>
    <a href="#">Riwayat Servis</a>
    <a href="#">Live Chat</a>
</nav>

<div class="auth-buttons">
    <?php if (!$nama_user): ?>
        <a href="auth/login.php">Masuk</a>
        <a href="auth/register.php">Daftar</a>
    <?php else: ?>
        <a href="auth/logout.php" class="logout">Logout</a>
    <?php endif; ?>
</div>

</body>
</html>
