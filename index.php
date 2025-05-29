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
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .topbar {
            background: #2c3e50;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h1 {
            margin: 0;
            font-size: 22px;
        }

        .auth-buttons {
            display: flex;
            gap: 10px;
        }

        .auth-buttons a {
            color: white;
            background: #3498db;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        header {
            padding: 40px 20px 20px;
            text-align: center;
            background: #ecf0f1;
        }

        nav.menu {
            text-align: center;
            margin: 30px 0;
        }

        .menu a {
            display: inline-block;
            margin: 10px 15px;
            padding: 12px 20px;
            background: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .menu a:hover {
            background: #27ae60;
        }

        .pesan {
            color: green;
            text-align: center;
            margin-top: 10px;
        }

        .greeting {
            text-align: center;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="topbar">
    <h1>Punjung Rejeki Motor</h1>
    <div class="auth-buttons">
        <?php if (!$nama_user): ?>
            <a href="auth/login.php">Masuk</a>
            <a href="auth/register.php">Daftar</a>
        <?php else: ?>
            <span style="margin-right: 10px;"> <a href="profile.php" style="color: white;"><?= htmlspecialchars($nama_user) ?></a></span>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'logout'): ?>
    <p class="pesan">Berhasil logout.</p>
<?php endif; ?>

<header>
    <h2>Selamat Datang di Punjung Rejeki Motor!</h2>
    <p>Layanan Servis Motor & Spare Part Berkualitas</p>
</header>

<nav class="menu">
    <a href="#">Booking Servis</a>
    <a href="#">Estimasi Biaya</a>
    <a href="#">Produk Spare Part</a>
    <a href="#">Riwayat Servis</a>
    <a href="#">Live Chat</a>
</nav>

</body>
</html>
