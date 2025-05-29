<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$role_user = $_SESSION['role_user'];
$pesan = '';
$info = '';

// Ambil data user
$stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $role_user === 'pelanggan') {
    if (isset($_POST['update'])) {
        $nama = trim($_POST['nama']);
        $password_baru = $_POST['password'];
        $konfirmasi = $_POST['konfirmasi'];

        if ($password_baru !== $konfirmasi) {
            $pesan = "Password dan konfirmasi tidak sama.";
        } else {
            if ($password_baru) {
                $hashed = password_hash($password_baru, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET nama_user = ?, password_user = ? WHERE id_user = ?");
                $stmt->bind_param("ssi", $nama, $hashed, $id_user);
            } else {
                $stmt = $conn->prepare("UPDATE users SET nama_user = ? WHERE id_user = ?");
                $stmt->bind_param("si", $nama, $id_user);
            }
            $stmt->execute();
            $_SESSION['nama_user'] = $nama;
            $info = "Profil berhasil diperbarui.";
        }
    }

    // Hapus akun
    if (isset($_POST['hapus'])) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id_user = ?");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        session_destroy();
        header("Location: index.php?pesan=akun_dihapus");
        exit;
    }
}
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
            width: 100%;
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
        }
        input[type="submit"]:hover {
            background: #27ae60;
        }
        form {
            margin-top: 20px;
        }
        .hapus-btn {
            background: #e74c3c;
            margin-top: 10px;
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

    <?php if ($pesan): ?><p class="alert"><?= $pesan ?></p><?php endif; ?>
    <?php if ($info): ?><p class="info"><?= $info ?></p><?php endif; ?>

    <p><strong>Nama:</strong> <?= htmlspecialchars($user['nama_user']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email_user']) ?></p>
    <!--<p><strong>Role:</strong> <?= htmlspecialchars($user['role_user']) ?></p>-->

    <?php if ($role_user === 'pelanggan'): ?>
        <form method="POST">
            <label>Ubah Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($user['nama_user']) ?>" required>

            <label>Ubah Password</label>
            <input type="password" name="password" placeholder="Password baru">
            <input type="password" name="konfirmasi" placeholder="Konfirmasi password baru">

            <input type="submit" name="update" value="Simpan Perubahan">

            <input type="submit" name="hapus" value="Hapus Akun" class="hapus-btn" onclick="return confirm('Yakin ingin menghapus akun?');">
        </form>
    <?php else: ?>
        <!--<p><em>Admin tidak dapat mengubah data profil.</em></p>-->
    <?php endif; ?>
</div>
</body>
</html>
