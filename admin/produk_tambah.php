<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['id_user']) || $_SESSION['role_user'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $stok = intval($_POST['stok']);
    $harga = intval($_POST['harga']);

    $stmt = $conn->prepare("INSERT INTO produk (nama_produk, kategori_produk, stok_produk, harga_produk) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $nama, $kategori, $stok, $harga);
    if ($stmt->execute()) {
        $pesan = "Produk berhasil ditambahkan.";
    } else {
        $pesan = "Gagal menambahkan produk.";
    }
}
$nama_user = $_SESSION['nama_user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #f39c12;
            --secondary: #e74c3c;
            --dark: #2c3e50;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('https://images.unsplash.com/photo-1601758003122-53c40e686a19?auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-attachment: fixed;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.7);
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
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255,255,255,0.95);
            padding: 30px;
            border-radius: 10px;
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

<div class="form-container">
    <h3 class="mb-4">Tambah Produk Baru</h3>
    <?php if ($pesan): ?>
        <div class="alert alert-info"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Produk</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
