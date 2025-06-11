<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role_user'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
$nama_user = $_SESSION['nama_user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Punjung Rejeki Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #f39c12;
            --secondary: #e74c3c;
            --dark: #2c3e50;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background: url('https://images.unsplash.com/photo-1601758003122-53c40e686a19') no-repeat center center fixed;
            background-size: cover;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: -1;
        }
        .topbar {
            background: linear-gradient(135deg, var(--dark), #1a252f);
            color: white;
            padding: 15px 30px;
            border-bottom: 3px solid var(--primary);
        }
        .logo {
            font-family: 'Bungee', cursive;
            font-size: 1.8rem;
            color: var(--primary);
        }
        .logo span {
            color: var(--secondary);
        }
        .admin-content {
            background: rgba(255,255,255,0.95);
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
        }
        .admin-content a {
            display: block;
            padding: 15px;
            margin: 15px auto;
            background: var(--primary);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .admin-content a:hover {
            background: var(--secondary);
        }
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <i class="fas fa-motorcycle me-3" style="font-size: 2rem; color: var(--primary);"></i>
        <h1 class="logo mb-0">Punjung <span>Rejeki</span> Motor</h1>
    </div>
    <div class="auth-buttons">
        <a href="../profile.php"><i class="fas fa-user me-2"></i><?= htmlspecialchars($nama_user) ?></a>
        <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<div class="admin-content">
    <h2>Halo, <?= htmlspecialchars($nama_user) ?></h2>
    <a href="booking_list.php"><i class="fas fa-list me-2"></i>Lihat Daftar Booking</a>
    <a href="produk_tambah.php"><i class="fas fa-plus-circle me-2"></i>Tambah Produk Baru</a>
</div>

</body>
</html>
