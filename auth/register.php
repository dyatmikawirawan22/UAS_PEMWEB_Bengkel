<?php
session_start();
require 'db.php'; // Pastikan path ini benar

$pesan = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $konfirmasi = trim($_POST['konfirmasi']);

    if ($nama == '' || $email == '' || $password == '' || $konfirmasi == '') {
        $pesan = "Semua kolom wajib diisi.";
    } elseif ($password !== $konfirmasi) {
        $pesan = "Konfirmasi password tidak cocok.";
    } else {
        // Cek apakah email sudah terdaftar
        $stmt = $conn->prepare("SELECT id_user FROM users WHERE email_user = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $pesan = "Email sudah terdaftar.";
        } else {
            // Hash password dan simpan ke database
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (nama_user, email_user, password_user) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $email, $hash);
            if ($stmt->execute()) {
                header("Location: login.php?pesan=berhasil_register");
                exit;
            } else {
                $pesan = "Registrasi gagal. Silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Punjung Rejeki Motor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .topbar {
            background-color: #2c3e50;
            padding: 15px 20px;
            text-align: center;
        }

        .title-link {
            font-size: 24px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .register-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin: 40px auto;
        }

        h2 {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #28a745;
            border: none;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #218838;
        }

        .alert {
            color: red;
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

    </style>
</head>
<body>

<!-- Header -->
<div class="topbar">
    <a href="index.php" class="title-link">Punjung Rejeki Motor</a>
</div>

<!-- Form Register -->
<div class="register-container">
    <h2>Daftar Akun Baru</h2>

    <?php if ($pesan): ?>
        <p class="alert"><?= htmlspecialchars($pesan) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="konfirmasi" placeholder="Konfirmasi Password" required>
        <input type="submit" value="Daftar">
    </form>

    <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
</div>

</body>
</html>
