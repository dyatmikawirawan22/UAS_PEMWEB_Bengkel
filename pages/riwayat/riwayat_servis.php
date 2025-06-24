<?php
include '../../includes/db.php'; 
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php?pesan=Silakan login terlebih dahulu");
    exit();
}

$nama_user = $_SESSION['nama_user'];
$id_user = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Servis - Punjung Rejeki Motor</title>
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
            background-image: url('../../haha.jpg');
            background-size: cover;
            background-attachment: fixed;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 200%;
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
        .container-custom {
            max-width: 1000px;
            margin: 60px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 16px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: var(--primary);
            color: white;
        }
        tr:nth-child(even) {
            background-color: #fdf2e9;
        }
        tr:hover {
            background-color: #ffe0b2;
        }
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <i class="fas fa-motorcycle me-3" style="font-size: 2rem; color: var(--primary);"></i>
        <a href="../../index.php" class="logo mb-0 text-decoration-none">Punjung <span>Rejeki</span> Motor</a>
    </div>
    <div class="auth-buttons d-flex gap-3">
        <a href="../../profile.php"><i class="fas fa-user me-2"></i><?= htmlspecialchars($nama_user) ?></a>
        <a href="../../auth/logout.php" style="background-color: var(--secondary); color: white;"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
    </div>
</div>

<div class="container container-custom">
    <h2 class="text-center mb-4">Riwayat Servis</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal Servis</th>
                <th>Jenis Kendaraan</th>
                <th>Keluhan</th>
                <th>Tindakan</th>
                <th>Biaya</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
<?php
$hasData = false;

// Data dari riwayat_servis (selesai)
$stmt = $conn->prepare("SELECT * FROM riwayat_servis WHERE id_user = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0):
    $hasData = true;
    while ($row = $result->fetch_assoc()):
?>
<tr>
    <td><?= $row["tanggal_riwayat"]; ?></td>
    <td><?= $row["jenis_kendaraan_riwayat"]; ?></td>
    <td><?= $row["keluhan_riwayat"]; ?></td>
    <td><?= $row["tindakan_riwayat"]; ?></td>
    <td>Rp <?= number_format($row["biaya_riwayat"], 0, ',', '.'); ?></td>
    <td><span class="badge bg-success">Selesai</span></td>
</tr>
<?php endwhile; endif; $stmt->close(); ?>

<?php
// Data dari bookings (belum selesai)
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id_user = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0):
    $hasData = true;
    while ($row = $result->fetch_assoc()):
        $status = $row["status_booking"];
        $badge = match ($status) {
            'Dikonfirmasi' => 'bg-primary',
            'Batal' => 'bg-danger',
            'Menunggu Konfirmasi' => 'bg-warning',
            default => 'bg-secondary'
        };
?>
<tr>
    <td><?= $row["tanggal_booking"]; ?></td>
    <td><?= $row["tipe_kendaraan_booking"]; ?></td>
    <td><?= $row["keluhan_booking"]; ?></td>
    <td>-</td>
    <td>-</td>
    <td><span class="badge <?= $badge ?>"><?= htmlspecialchars($status) ?></span></td>
</tr>
<?php endwhile; endif; $stmt->close(); ?>

<?php if (!$hasData): ?>
<tr><td colspan="6" class="text-center">Tidak ada riwayat servis atau booking yang tersedia.</td></tr>
<?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
