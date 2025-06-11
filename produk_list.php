<?php include 'include/db.php'; 
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

        .topbar {
            background: linear-gradient(135deg, var(--dark) 0%, #1a252f 100%);
            color: white;
            padding: 15px 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-bottom: 3px solid var(--primary);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('https://images.unsplash.com/photo-1589927986089-35812388d1e3') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            max-width: 1000px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        th, td {
            padding: 12px 16px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ff9800;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #fdf2e9;
        }

        tr:hover {
            background-color: #ffe0b2;
        }

        .badge-stok {
            background-color: #ff5722;
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn-primary {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: #ff9800;
        color: white;
        padding: 14px 20px;
        border-radius: 50px;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        transition: background-color 0.3s ease, transform 0.3s ease;
        z-index: 999;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            background-image: url('https://images.unsplash.com/photo-1601758003122-53c40e686a19?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
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
            height: 133%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: -1;
            background-size: auto;
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
        
                    
    </style>
</head>
<body>

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


<div class="container">
    <h2>📦 Daftar Produk Tersedia</h2>
    <table>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM produk";
            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $row["id_produk"]; ?></td>
                    <td><?= $row["nama_produk"]; ?></td>
                    <td><?= $row["kategori_produk"]; ?></td>
                    <td><span class="badge-stok"><?= $row["stok_produk"]; ?></span></td>
                    <td>Rp <?= number_format($row["harga_produk"], 0, ',', '.'); ?></td>
                </tr>
            <?php
                endwhile;
            else:
                echo "<tr><td colspan='5'>Tidak ada data produk.</td></tr>";
            endif;

            $conn->close();

            
            ?>
        </tbody>
    </table>


</body>

<div>   
        <a href="index.php" class="btn-primary"><i class="fas fa-home me-1"></i> Kembali ke Beranda</a>
            </div>

            </html>
