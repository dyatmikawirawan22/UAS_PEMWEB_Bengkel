<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role_user'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
$nama_user = $_SESSION['nama_user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Punjung Rejeki Motor</title>
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
            background: url('../haha.jpg') no-repeat center center fixed;
            background-size: cover;
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
        .admin-content {
            background: rgba(255,255,255,0.95);
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
        }
        .admin-content a {
            display: block;
            padding: 15px;
            margin: 15px auto;
            background: var(--primary);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .admin-content a:hover {
            background: var(--secondary);
        }
        .hero {
            background: rgba(44, 62, 80, 0.85);
            color: white;
            padding: 30px 20px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border-left: 5px solid var(--primary);
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 100%;
            background-image: url('https://cdn-icons-png.flaticon.com/512/2037/2037075.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center right;
            opacity: 0.1;
        }
        
        .hero h2 {
            font-family: 'Bungee', cursive;
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }
        .btn-menu {
            min-width: 200px;
            padding: 12px 25px;
            margin: 10px;
            border-radius: 50px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }
        
        .btn-menu::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            transition: all 0.4s ease;
        }
        
        .btn-menu:hover::after {
            left: 100%;
        }
        
        .btn-booking {
            background: linear-gradient(45deg, var(--primary), #f1c40f);
        }
        
        .btn-estimasi {
            background: linear-gradient(45deg, #3498db, #2980b9);
        }
        
        .btn-chat {
            background: linear-gradient(45deg, var(--secondary), #c0392b);
        }
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <i class="fas fa-motorcycle me-3" style="font-size: 2rem; color: var(--primary);"></i>
        <h1 class="logo mb-0">Punjung <span>Rejeki</span> Motor</h1>
    </div>
    <div class="auth-buttons">
        <a><i class="fas fa-user me-2"></i><?= htmlspecialchars($nama_user) ?></a>
         <a href="../auth/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
    </div>
</div>

<div class="container">
    <div class="hero text-center">
        <h2>Halo, <?= htmlspecialchars($nama_user) ?></h2>
        <div class="mt-5">
            <img src="https://cdn-icons-png.flaticon.com/512/2777/2777154.png" alt="Motorcycle" width="120" class="motor-icon">
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-6 col-md-4 mb-3">
        <a href="booking_list.php" class="btn btn-booking btn-menu w-100">
            <i class="fas fa-calendar-check me-2"></i> Daftar Booking
        </a>
    </div>
    <div class="col-6 col-md-4 mb-3">
        <a href="produk_tambah.php" class="btn btn-estimasi btn-menu w-100">
            <i class="fas fa-calculator me-2"></i> Sparepart
        </a>
    </div>
    <div class="col-6 col-md-4 mb-3">
        <a href="../pages/chat/chat.php" class="btn btn-chat btn-menu w-100">
            <i class="fas fa-comments me-2"></i> Live Chat
        </a>
    </div>
</div>


</body>
</html>
