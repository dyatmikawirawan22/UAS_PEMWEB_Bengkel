<?php
session_start();
$nama_user = isset($_SESSION['nama_user']) ? $_SESSION['nama_user'] : null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Estimasi Biaya - Punjung Rejeki Motor</title>
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
            background-image: url('../../haha.jpg');
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
        
        .estimasi-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            border-left: 5px solid var(--primary);
            overflow: hidden;
            margin-top: 30px;
        }
        
        .estimasi-header {
            background: linear-gradient(90deg, var(--dark), var(--primary));
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
        }
        
        .price-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s;
            cursor: pointer;
            border: 2px solid #ddd;
        }
        
        .price-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .price-card.selected {
            border-color: var(--primary);
            background-color: rgba(243, 156, 18, 0.1);
        }
        
        .price-title {
            font-weight: bold;
            color: var(--dark);
            font-size: 1.2rem;
        }
        
        .price-amount {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary);
            margin: 10px 0;
        }
        
        .price-features {
            list-style: none;
            padding-left: 0;
        }
        
        .price-features li {
            padding: 5px 0;
            position: relative;
            padding-left: 25px;
        }
        
        .price-features li:before {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            color: var(--primary);
        }
        
        .btn-calculate {
            background: linear-gradient(45deg, var(--primary), #f1c40f);
            border: none;
            padding: 12px 30px;
            font-weight: bold;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .btn-calculate:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }
        
        .result-card {
            background: rgba(46, 204, 113, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            border-left: 4px solid #2ecc71;
        }
        
        .result-title {
            font-weight: bold;
            color: var(--dark);
        }
        
        .result-amount {
            font-size: 2rem;
            font-weight: bold;
            color: #2ecc71;
        }
    </style>
</head>
<body>

<!-- Top Bar -->
<div class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <i class="fas fa-motorcycle me-3" style="font-size: 2rem; color: var(--primary);"></i>
        <a href="../../index.php" class="logo mb-0">Punjung <span>Rejeki</span> Motor</a>
    </div>
    <div class="auth-buttons d-flex gap-3">
        <?php if (!$nama_user): ?>
            <a href="../../auth/login.php"><i class="fas fa-sign-in-alt me-2"></i>Masuk</a>
            <a href="../../auth/register.php"><i class="fas fa-user-plus me-2"></i>Daftar</a>
        <?php else: ?>
            <a href="../../profile.php"><i class="fas fa-user me-2"></i><?= htmlspecialchars($nama_user) ?></a>
            <a href="../../auth/logout.php" style="background-color: var(--secondary); color: white;"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="estimasi-card">
                <div class="estimasi-header">
                    <h3 class="mb-0"><i class="fas fa-calculator me-2"></i> ESTIMASI BIAYA SERVIS</h3>
                </div>
                <div class="p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-dollar-sign" style="font-size: 3rem; color: var(--primary);"></i>
                        <h4 class="mt-2">Pilih Jenis Servis Untuk Melihat Estimasi Biaya</h4>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="price-card" onclick="selectService(this, 'ringan')">
                                <div class="price-title">SERVIS RINGAN</div>
                                <div class="price-amount">Rp 150.000</div>
                                <ul class="price-features">
                                    <li>Ganti oli mesin</li>
                                    <li>Pembersihan filter udara</li>
                                    <li>Pengecekan standar</li>
                                    <li>Pengecekan tekanan ban</li>
                                    <li>Garansi 1 minggu</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="price-card" onclick="selectService(this, 'berkala')">
                                <div class="price-title">SERVIS BERKALA</div>
                                <div class="price-amount">Rp 350.000</div>
                                <ul class="price-features">
                                    <li>Semua servis ringan</li>
                                    <li>Ganti busi</li>
                                    <li>Pembersihan karburator</li>
                                    <li>Penyetelan rem</li>
                                    <li>Tune up mesin</li>
                                    <li>Garansi 2 minggu</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="price-card" onclick="selectService(this, 'besar')">
                                <div class="price-title">SERVIS BESAR</div>
                                <div class="price-amount">Rp 750.000+</div>
                                <ul class="price-features">
                                    <li>Semua servis berkala</li>
                                    <li>Overhaul mesin</li>
                                    <li>Ganti kampas rem</li>
                                    <li>Ganti rantai & gir</li>
                                    <li>Pengecekan kelistrikan</li>
                                    <li>Garansi 1 bulan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button id="btnCalculate" class="btn btn-calculate" onclick="calculateEstimate()">
                            <i class="fas fa-calculator me-2"></i> HITUNG ESTIMASI
                        </button>
                    </div>
                    
                    <div id="resultContainer" class="result-card" style="display: none;">
                        <div class="text-center">
                            <div class="result-title">TOTAL ESTIMASI BIAYA</div>
                            <div class="result-amount" id="totalEstimate">Rp 0</div>
                            <p class="mt-2">* Harga dapat berubah setelah pemeriksaan oleh teknisi</p>
                            
                            <a href="../booking/booking.php" class="btn btn-success mt-3">
                                <i class="fas fa-calendar-check me-2"></i> BOOKING SEKARANG
                            </a>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <div class="alert alert-info">
                            <h5><i class="fas fa-info-circle me-2"></i> Informasi Tambahan</h5>
                            <ul>
                                <li>Harga belum termasuk spare part yang perlu diganti</li>
                                <li>Servis besar memerlukan pemeriksaan terlebih dahulu</li>
                                <li>Diskon 10% untuk pelanggan yang sudah servis 3x</li>
                                <li>Free penjemputan motor untuk servis besar (area tertentu)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let selectedService = null;
    const prices = {
        ringan: 150000,
        berkala: 350000,
        besar: 750000
    };
    
    function selectService(card, service) {
        // Remove selected class from all cards
        document.querySelectorAll('.price-card').forEach(c => {
            c.classList.remove('selected');
        });
        
        // Add selected class to clicked card
        card.classList.add('selected');
        selectedService = service;
    }
    
    function calculateEstimate() {
        if (!selectedService) {
            alert('Silahkan pilih jenis servis terlebih dahulu');
            return;
        }
        
        // Calculate total (in a real app, this would be more complex)
        let total = prices[selectedService];
        
        // Display result
        document.getElementById('totalEstimate').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('resultContainer').style.display = 'block';
        
        // Scroll to result
        document.getElementById('resultContainer').scrollIntoView({ behavior: 'smooth' });
        
        // Change button text
        document.getElementById('btnCalculate').innerHTML = '<i class="fas fa-sync-alt me-2"></i> HITUNG ULANG';
    }
</script>

</body>
</html>
