<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$role_user = $_SESSION['role_user'];

// Ambil data user
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
    <style>
        .topbar {
            background-color: #2c3e50;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
        }

        .title-link {
            font-size: 24px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        .alert { color: red; text-align: center; }
        .info { color: green; text-align: center; }
        input[type="text"], input[type="password"] {
            width: 95%;
            padding: 10px;
            margin: 8px 0;
        }
        input[type="submit"] {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            margin-top: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #27ae60;
        }
        form {
            margin-top: 20px;
        }
        input[type="hapus"] {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 10px;
            width: 96%;
            margin-top: 10px;
            cursor: pointer;
            text-align: center;
        }
        input[type="hapus"]:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>

<div class="topbar">
    <a href="index.php" class="title-link">Punjung Rejeki Motor</a>
    <a href="auth/logout.php" style="color: white; background: #e74c3c; padding: 6px 12px; text-decoration: none; border-radius: 4px; margin-left: 10px;">Keluar</a>
</div>

<div class="container">
    <h2>Profil Anda</h2>

    <?php if ($pesan): ?><p class="alert"><?= htmlspecialchars($pesan) ?></p><?php endif; ?>
    <?php if ($info): ?><p class="info"><?= htmlspecialchars($info) ?></p><?php endif; ?>

    <p><strong>Nama:</strong> <?= htmlspecialchars($user['nama_user']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email_user']) ?></p>

    <?php if ($role_user === 'pelanggan'): ?>
        <!-- Ubah Nama -->
        <form method="POST" action="profile/ubah_nama.php">
            <label>Ubah Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($user['nama_user']) ?>" required>
            <input type="submit" value="Simpan Nama">
        </form>

        <!-- Ubah Password -->
        <form method="POST" action="profile/ubah_password.php">
            <label>Ubah Password</label>
            <input type="password" name="password" placeholder="Password baru" required>
            <input type="password" name="konfirmasi" placeholder="Konfirmasi password baru" required>
            <input type="submit" value="Simpan Password">
        </form>

        <!-- Hapus Akun -->
        <form method="POST" action="profile/hapus_akun.php" onclick="return confirm('Yakin ingin menghapus akun?');">
            <input type="hapus" value="Hapus Akun" >
        </form>
    <?php endif; ?>
</div>
</body>
</html>
