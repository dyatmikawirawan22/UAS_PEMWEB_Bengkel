<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role_user'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$nama_user = $_SESSION['nama_user'];
$pesan = '';

// Tambah Produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_produk'])) {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $stok = intval($_POST['stok']);
    $harga = intval($_POST['harga']);

    $stmt = $conn->prepare("INSERT INTO produk (nama_produk, kategori_produk, stok_produk, harga_produk) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $nama, $kategori, $stok, $harga);
    $pesan = $stmt->execute() ? "Produk berhasil ditambahkan." : "Gagal menambahkan produk.";
}

// Hapus Produk
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $conn->query("DELETE FROM produk WHERE id_produk = $id");
    header("Location: produk_tambah.php?pesan=Produk dihapus");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Produk</title>
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
            background-image: url('../haha.jpg');
            background-size: cover;
            background-attachment: fixed;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 115%;
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
        .topbar .auth-buttons a {
            color: white;
            background: var(--primary);
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .topbar .auth-buttons a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0,0,0,0.15);
            background: transparent;
            border-color: var(--primary);
        }
        
        .topbar .auth-buttons .logout-btn {
            background: var(--secondary);
        }
        
        .topbar .auth-buttons .logout-btn:hover {
            background: transparent;
            border-color: var(--secondary);
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
        }
        .form-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }
        .badge-stok {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 14px;
            color: white;
        }
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
        
        
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <i class="fas fa-motorcycle me-3" style="font-size: 2rem; color: var(--primary);"></i>
        <a href="admin_dashboard.php" class="logo mb-0 text-decoration-none">Punjung <span>Rejeki</span> Motor</a>
    </div>
    <div class="auth-buttons d-flex gap-3">
        <a ><i class="fas fa-user me-2"></i><?= htmlspecialchars($nama_user) ?></a>
        <a href="../../auth/logout.php" style="background-color: var(--secondary); color: white;"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
    </div>
</div>

<div class="container">
    <h3 class="form-title">🛠️ Tambah Produk Baru</h3>

    <?php if ($pesan || isset($_GET['pesan'])): ?>
        <div class="alert alert-info"><?= htmlspecialchars($pesan ?: $_GET['pesan']) ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-4">
        <input type="hidden" name="tambah_produk" value="1">
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
        <button type="submit" class="btn btn-warning"><i class="fas fa-plus-circle me-1"></i> Tambah Produk</button>
    </form>

    <h4 class="mb-3">📦 Daftar Produk</h4>
    <table class="table table-bordered">
        <thead class="table-warning">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $data = $conn->query("SELECT * FROM produk");
        if ($data->num_rows > 0):
            while ($row = $data->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['id_produk'] ?></td>
            <td><?= $row['nama_produk'] ?></td>
            <td><?= $row['kategori_produk'] ?></td>
            <td>
                <span class="badge-stok <?= $row['stok_produk'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                    <?= $row['stok_produk'] > 0 ? 'Ada' : 'Habis' ?>
                </span>
            </td>
            <td>Rp <?= number_format($row['harga_produk'], 0, ',', '.') ?></td>
            <td>
                <a href="produk_edit.php?id=<?= $row['id_produk'] ?>" class="btn btn-sm btn-primary"">Edit</a>
                <a href="?hapus=<?= $row['id_produk'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus produk ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="6" class="text-center">Belum ada produk</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
<div>   
<div>   
   </html>
