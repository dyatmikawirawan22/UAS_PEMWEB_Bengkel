<?php
session_start();
require '../includes/db.php';

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
        $stmt = $conn->prepare("SELECT id_user FROM users WHERE email_user = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $pesan = "Email sudah terdaftar.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (nama_user, email_user, password_user, role_user) VALUES (?, ?, ?, 'pelanggan')");
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
    <!-- Bootstrap & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background-image: url('../haha.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border-left: 5px solid var(--primary);
            width: 100%;
            max-width: 450px;
            margin: auto;
            padding: 40px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .login-header h2 {
            font-family: 'Bungee', cursive;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 2px solid #ddd;
            padding-left: 15px;
            margin-bottom: 20px;
        }

        .btn-login {
            background: linear-gradient(45deg, var(--primary), #f1c40f);
            border: none;
            color: white;
            font-weight: bold;
            padding: 12px;
            border-radius: 50px;
            width: 100%;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }

        .alert {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            border-left: 4px solid var(--secondary);
            color: #721c24;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: var(--dark);
        }

        .register-link a {
            color: var(--primary);
            font-weight: bold;
        }

        .register-link a:hover {
            color: var(--secondary);
            text-decoration: none;
        }
    </style>
</head>
<body>

<!-- Top Bar -->
<div class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <i class="fas fa-motorcycle me-3" style="font-size: 2rem; color: var(--primary);"></i>
        <a href="../index.php" class="logo mb-0">Punjung <span>Rejeki</span> Motor</a>
    </div>
</div>

<!-- Register Form -->
<div class="container my-auto">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="login-card">
                <div class="login-header">
                    <i class="fas fa-user-plus"></i>
                    <h2>DAFTAR AKUN BARU</h2>
                    <p>Silahkan isi data untuk membuat akun pelanggan</p>
                </div>

                <?php if ($pesan): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($pesan) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required>
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <input type="password" class="form-control" name="konfirmasi" placeholder="Konfirmasi Password" required>
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-user-plus me-2"></i> DAFTAR
                    </button>
                </form>

                <div class="register-link">
                    Sudah punya akun? <a href="login.php">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
