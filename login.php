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
        $_SESSION['role_user'] = $user['role_user'];

        if ($user['role_user'] === 'admin') {
            header("Location: ../admin/admin_dashboard.php");
        } else {
            header("Location: ../index.php");
        }
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
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
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
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(243, 156, 18, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(45deg, var(--primary), #f1c40f);
            border: none;
            color: white;
            font-weight: bold;
            padding: 12px;
            border-radius: 50px;
            width: 100%;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }
        
        .alert {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid transparent;
        }
        
        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            border-left-color: var(--secondary);
            color: #721c24;
        }
        
        .alert-success {
            background-color: rgba(46, 204, 113, 0.1);
            border-left-color: #2ecc71;
            color: #155724;
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: var(--dark);
        }
        
        .register-link a {
            color: var(--primary);
            font-weight: bold;
            transition: all 0.3s;
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

<!-- Login Form -->
<div class="container my-auto">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="login-card">
                <div class="login-header">
                    <i class="fas fa-sign-in-alt"></i>
                    <h2>MASUK KE AKUN ANDA</h2>
                    <p>Silahkan masuk untuk mengakses layanan bengkel kami</p>
                </div>

                <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'logout'): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i> Anda berhasil logout.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil_register'): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i> Berhasil mendaftarkan akun.
                    </div>
                <?php endif; ?>

                <?php if ($pesan): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($pesan) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Alamat Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> MASUK
                    </button>
                </form>

                <div class="register-link">
                    Belum punya akun? <a href="register.php">Daftar sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Animasi saat hover tombol
    document.querySelector('.btn-login').addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-3px)';
        this.style.boxShadow = '0 8px 15px rgba(0,0,0,0.2)';
    });
    
    document.querySelector('.btn-login').addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = 'none';
    });
</script>

</body>
</html>
