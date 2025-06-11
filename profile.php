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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
        }
        .topbar {
            background-color: #2c3e50;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
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

<div class="topbar">
    <a href="index.php" class="title-link">Punjung Rejeki Motor</a>
    <a href="auth/logout.php" class="logout-link"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
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
