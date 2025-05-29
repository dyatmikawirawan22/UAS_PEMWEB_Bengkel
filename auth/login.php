<?php
session_start();
require '../includes/db.php'; // Pastikan path sesuai

$pesan = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == '' || $password == '') {
        $pesan = 'Email dan password wajib diisi.';
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email_user = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password_user'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama_user'] = $user['nama_user'];
            header("Location: ../index.php"); // Arahkan ke halaman utama
            exit;
        } else {
            $pesan = 'Email atau password salah.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Punjung Rejeki Motor</title>
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

        .login-container {
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
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .alert {
            color: red;
            margin-bottom: 10px;
        }

        .info {
            color: green;
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="topbar">
    <a href="../index.php" class="title-link">Punjung Rejeki Motor</a>
</div>

<!-- Form login -->
<div class="login-container">
    <h2>Masuk ke Punjung Rejeki Motor</h2>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'logout'): ?>
        <p class="info">Anda berhasil logout.</p>
    <?php endif; ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil_register'): ?>
        <p class="info">Registrasi berhasil. Silakan login.</p>
    <?php endif; ?>

    <?php if ($pesan): ?>
        <p class="alert"><?= htmlspecialchars($pesan) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Masuk">
    </form>

    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</div>

</body>
</html>
