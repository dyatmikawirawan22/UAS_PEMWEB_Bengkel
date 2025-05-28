<?php
require '../includes/db.php';

$pesan = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $konfirmasi = trim($_POST['konfirmasi']);

    if ($nama == '' || $email == '' || $password == '' || $konfirmasi == '') {
        $pesan = "Semua field wajib diisi.";
    } elseif ($password !== $konfirmasi) {
        $pesan = "Password dan konfirmasi tidak cocok.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email_user = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $pesan = "Email sudah terdaftar.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (nama_user, email_user, password_user) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $email, $hash);
            if ($stmt->execute()) {
                header("Location: login.php?pesan=daftar_sukses");
                exit;
            } else {
                $pesan = "Gagal mendaftar. Silakan coba lagi.";
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
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
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Daftar Akun Baru</h2>

    <?php if ($pesan): ?>
        <p class="alert"><?= $pesan ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="nama" placeholder="Nama" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="konfirmasi" placeholder="Konfirmasi Password" required><br>
        <input type="submit" value="Daftar">
    </form>

    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</div>

</body>
</html>
