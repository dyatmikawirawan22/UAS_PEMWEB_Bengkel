<?php
session_start();
$nama_user = isset($_SESSION['nama_user']) ? $_SESSION['nama_user'] : null;
$role_user = $_SESSION['role_user'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Punjung Rejeki Motor - Bengkel Spesialis Motor</title>
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
            background-image: url('haha.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
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
        
        .hero {
            background: rgba(44, 62, 80, 0.85);
            color: white;
            padding: 80px 20px;
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
        
        .btn-produk {
            background: linear-gradient(45deg, #2ecc71, #27ae60);
        }
        
        .btn-riwayat {
            background: linear-gradient(45deg, #9b59b6, #8e44ad);
        }
        
        .btn-chat {
            background: linear-gradient(45deg, var(--secondary), #c0392b);
        }
        
        .features {
            background: rgba(255,255,255,0.9);
            padding: 40px;
            border-radius: 10px;
            margin-top: 40px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .feature-title {
            font-weight: bold;
            color: var(--dark);
            margin-bottom: 10px;
        }
        
        .greeting {
            color: white;
            text-align: center;
            margin: 20px 0;
            font-size: 1.2rem;
        }
        
        .greeting span {
            color: var(--primary);
            font-weight: bold;
        }
        
        .pesan {
            color: #2ecc71;
            text-align: center;
            margin: 15px 0;
            font-weight: bold;
            background: rgba(46, 204, 113, 0.1);
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #2ecc71;
        }
        
        .motor-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .promo-banner {
            background: linear-gradient(90deg, var(--secondary), var(--primary));
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

<!-- Top Bar -->
<div class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <i class="fas fa-motorcycle me-3" style="font-size: 2rem; color: var(--primary);"></i>
        <h1 class="logo mb-0">Punjung <span>Rejeki</span> Motor</h1>
    </div>
    <div class="auth-buttons d-flex gap-3">
        <?php if (!$nama_user): ?>
            <a href="auth/login.php"><i class="fas fa-sign-in-alt me-2"></i>Masuk</a>
            <a href="auth/register.php"><i class="fas fa-user-plus me-2"></i>Daftar</a>
        <?php else: ?>
            <a href="profile.php"><i class="fas fa-user me-2"></i><?= htmlspecialchars($nama_user) ?></a>
            <a href="auth/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($_GET['pesan'])): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <?= htmlspecialchars($_GET['pesan']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Notifikasi -->
<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'logout'): ?>
    <div class="container">
        <p class="pesan"><i class="fas fa-check-circle me-2"></i>Berhasil logout.</p>
    </div>
<?php endif; ?>

<!-- Promo Banner -->
<div class="container">
    <div class="promo-banner">
        <i class="fas fa-tag me-2"></i> PROMO BULAN INI: Servis berkala + Ganti oli hanya Rp 150.000!
    </div>
</div>

<!-- Hero Section -->
<div class="container">
    <div class="hero text-center">
        <h2>LAYANAN BENGKEL MOTOR PREMIUM</h2>
        <p class="lead">Dengan teknisi berpengalaman lebih dari 10 tahun dan menggunakan sparepart original, kami siap membuat motor Anda kembali seperti baru!</p>
        
        <div class="mt-5">
            <img src="https://cdn-icons-png.flaticon.com/512/2777/2777154.png" alt="Motorcycle" width="120" class="motor-icon">
        </div>
    </div>
</div>

<!-- Menu -->
<div class="container text-center mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="col-6 col-md-4 mb-3">
                    <a href="pages/booking/booking.php" class="btn btn-booking btn-menu">
                        <i class="fas fa-calendar-check me-2"></i> Booking
                    </a>
                </div>
                <div class="col-6 col-md-4 mb-3">
                    <a href="pages/estimasi/estimasi_biaya.php" class="btn btn-estimasi btn-menu">
                        <i class="fas fa-calculator me-2"></i> Estimasi
                    </a>
                </div>
                <div class="col-6 col-md-4 mb-3">
                    <a href="pages/produk/produk_list.php" class="btn btn-produk btn-menu">
                        <i class="fas fa-cogs me-2"></i> Sparepart
                    </a>
                </div>
                <div class="col-6 col-md-6 mb-3">
                    <a href="pages/riwayat/riwayat_servis.php" class="btn btn-riwayat btn-menu">
                        <i class="fas fa-history me-2"></i> Riwayat Servis
                    </a>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <a href="pages/chat/chat.php" class="btn btn-chat btn-menu">
                        <i class="fas fa-comments me-2"></i> Live Chat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features -->
<div class="container features mt-5">
    <div class="row text-center">
        <div class="col-md-3 mb-4">
            <div class="feature-icon">
                <i class="fas fa-clock"></i>
            </div>
            <h4 class="feature-title">Cepat</h4>
            <p>Proses servis cepat dengan standar waktu yang ketat</p>
        </div>
        <div class="col-md-3 mb-4">
            <div class="feature-icon">
                <i class="fas fa-award"></i>
            </div>
            <h4 class="feature-title">Berkualitas</h4>
            <p>Menggunakan alat dan sparepart terbaik</p>
        </div>
        <div class="col-md-3 mb-4">
            <div class="feature-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <h4 class="feature-title">Harga Terbaik</h4>
            <p>Harga kompetitif dengan kualitas premium</p>
        </div>
        <div class="col-md-3 mb-4">
            <div class="feature-icon">
                <i class="fas fa-headset"></i>
            </div>
            <h4 class="feature-title">24/7 Support</h4>
            <p>Layanan darurat siap membantu kapan saja</p>
        </div>
    </div>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Animasi tombol saat hover
    document.querySelectorAll('.btn-menu').forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 8px 15px rgba(0,0,0,0.2)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
        });
    });
</script>

</body>
</html>
