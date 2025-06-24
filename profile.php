<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$role_user = $_SESSION['role_user'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$pesan = $_GET['error'] ?? '';
$info = $_GET['info'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil - Punjung Rejeki Motor</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #f39c12;
            --secondary: #e74c3c;
            --dark: #2c3e50;
            --light: #ecf0f1;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
        }
        .topbar {
            background: linear-gradient(135deg, var(--dark) 0%, #1a252f 100%);
            color: white;
            padding: 15px 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-bottom: 3px solid var(--primary);
        }
        
        .logo {
            font-family: 'Bungee', cursive;
            font-size: 1.8rem;
            color: var(--primary);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            text-decoration: none;
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
        .title-link {
            font-size: 24px;
            font-weight: bold;
            color: #f39c12;
            text-decoration: none;
        }
        .logout-link {
            color: white;
            background-color: #e74c3c;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
        }
        .logout-link:hover {
            background-color: #c0392b;
        }
        .container {
            max-width: 550px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <i class="fas fa-motorcycle me-3" style="font-size: 2rem; color: var(--primary);"></i>
        <a href="index.php" class="logo mb-0">Punjung <span>Rejeki</span> Motor</a>
    </div>
     <div class="auth-buttons d-flex gap-3">
        <a href="auth/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
    </div>
</div>

<div class="container">
    <h2>Profil Anda</h2>

    <?php if ($pesan): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>
    <?php if ($info): ?>
        <div class="alert alert-success"><?= htmlspecialchars($info) ?></div>
    <?php endif; ?>

    <p><strong>Nama:</strong> <?= htmlspecialchars($user['nama_user']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email_user']) ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars($user['role_user']) ?></p>

    <?php if ($role_user === 'pelanggan'): ?>
        <form action="profile/ubah_nama.php" method="POST">
            <label class="form-label">Ubah Nama</label>
            <input type="text" name="nama" class="form-control mb-3" value="<?= htmlspecialchars($user['nama_user']) ?>" required>
            <button type="submit" class="btn btn-warning w-100 mb-4">Simpan Nama</button>
        </form>

        <form action="profile/ubah_password.php" method="POST">
            <label class="form-label">Ubah Password</label>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password baru" required>
            <input type="password" name="konfirmasi" class="form-control mb-3" placeholder="Konfirmasi password baru" required>
            <button type="submit" class="btn btn-warning w-100 mb-4">Simpan Password</button>
        </form>

        <form action="profile/hapus_akun.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
            <button type="submit" name="hapus" class="btn btn-danger w-100">Hapus Akun</button>
        </form>
    <?php else: ?>
        <div class="alert alert-info mt-4">Admin tidak dapat mengubah profil.</div>
    <?php endif; ?>
</div>

</body>
</html>
