<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['id_user']) || $_SESSION['role_user'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
$nama_user = $_SESSION['nama_user'];
if (isset($_GET['konfirmasi'])) {
    $id_booking = $_GET['konfirmasi'];
    mysqli_query($conn, "UPDATE bookings SET status_booking='Dikonfirmasi' WHERE id_booking=$id_booking");
    header("Location: booking_list.php?pesan=Berhasil dikonfirmasi");
    exit;
}
$result = mysqli_query($conn, "SELECT b.*, u.nama_user FROM bookings b JOIN users u ON b.id_user = u.id_user");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Booking - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #f39c12;
            --secondary: #e74c3c;
            --dark: #2c3e50;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('https://images.unsplash.com/photo-1601758003122-53c40e686a19?auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-attachment: fixed;
            position: relative;
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
        .container-custom {
            max-width: 1000px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
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
        <a href="../profile.php"><i class="fas fa-user me-2"></i><?= htmlspecialchars($nama_user) ?></a>
        <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<div class="container container-custom">
    <h3 class="mb-4">Daftar Booking Pelanggan</h3>
    <?php if (isset($_GET['pesan'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['pesan']) ?></div>
    <?php endif; ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>Nama</th>
            <th>Tipe</th>
            <th>NoPol</th>
            <th>Tanggal</th>
            <th>Servis</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['nama_user'] ?></td>
                <td><?= $row['tipe_kendaraan_booking'] ?></td>
                <td><?= $row['nopol_booking'] ?></td>
                <td><?= $row['tanggal_booking'] ?></td>
                <td><?= $row['jenis_servis_booking'] ?></td>
                <td><?= $row['status_booking'] ?></td>
                <td>
                    <?php if ($row['status_booking'] === 'Menunggu Konfirmasi'): ?>
                        <a href="?konfirmasi=<?= $row['id_booking'] ?>" class="btn btn-success btn-sm">Konfirmasi</a>
                    <?php else: ?>
                        <span class="text-muted">✓</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
