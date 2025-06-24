<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role_user'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$nama_user = $_SESSION['nama_user'];

// Proses update status booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id_booking = $_POST['id_booking'];
    $status = $_POST['status_booking'];

    // Update status
    $stmt = $conn->prepare("UPDATE bookings SET status_booking = ? WHERE id_booking = ?");
    $stmt->bind_param("si", $status, $id_booking);
    $stmt->execute();

    // Jika status selesai, masukkan ke riwayat
    if ($status === 'Selesai' && !empty($_POST['tindakan']) && !empty($_POST['biaya'])) {
        $tindakan = $_POST['tindakan'];
        $biaya = (int) $_POST['biaya'];

        // Ambil data booking
        $result = $conn->query("SELECT * FROM bookings WHERE id_booking = $id_booking");
        $b = $result->fetch_assoc();

        $stmt = $conn->prepare("INSERT INTO riwayat_servis (id_user, jenis_kendaraan_riwayat, tanggal_riwayat, keluhan_riwayat, tindakan_riwayat, biaya_riwayat)
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "issssi",
            $b['id_user'],
            $b['tipe_kendaraan_booking'],
            $b['tanggal_booking'],
            $b['keluhan_booking'],
            $tindakan,
            $biaya
        );
        $stmt->execute();
    }

    header("Location: booking_list.php?pesan=Status berhasil diperbarui");
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
            background-image: url('../haha.jpg');
            background-size: cover;
            background-attachment: fixed;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 130%;
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
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }
        .form-inline {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        textarea {
            resize: none;
       
    </style>
</head>
<body>

<div class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <i class="fas fa-motorcycle me-3" style="font-size: 2rem; color: var(--primary);"></i>
        <a href="admin_dashboard.php" class="logo mb-0 text-decoration-none">Punjung <span>Rejeki</span> Motor</a>
    </div>
    <div class="auth-buttons d-flex gap-3">
        <a ><i class="fas fa-user me-2"></i><?= htmlspecialchars($nama_user) ?></a>
        <a href="../../auth/logout.php" style="background-color: var(--secondary); color: white;"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
    </div>
</div>

<div class="container container-custom">
    <h3 class="mb-4">Daftar Booking</h3>

    <?php if (isset($_GET['pesan'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['pesan']) ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Kendaraan</th>
                <th>Tanggal</th>
                <th>Servis</th>
                <th>Status</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_user']) ?></td>
                <td><?= htmlspecialchars($row['tipe_kendaraan_booking']) ?> (<?= htmlspecialchars($row['nopol_booking']) ?>)</td>
                <td><?= $row['tanggal_booking'] ?></td>
                <td><?= $row['jenis_servis_booking'] ?></td>
                <td><span class="badge bg-secondary"><?= $row['status_booking'] ?></span></td>
                <td>
                    <?php
                    $disabled = ($row['status_booking'] === 'Batal' || $row['status_booking'] === 'Selesai');
                    ?>
                    <form method="POST" class="form-inline" <?= $disabled ? 'onsubmit="return false;"' : '' ?>>

                        <input type="hidden" name="id_booking" value="<?= $row['id_booking'] ?>">
                        <select name="status_booking" class="form-select" <?= $disabled ? 'disabled' : '' ?> required>
                            <?php
                            $current = $row['status_booking'];
                            if ($current === 'Menunggu Konfirmasi') {
                                echo '<option value="Menunggu Konfirmasi" selected>Menunggu Konfirmasi</option>';
                                echo '<option value="Dikonfirmasi">Dikonfirmasi</option>';
                                echo '<option value="Batal">Batal</option>';
                                echo '<option value="Selesai">Selesai</option>';
                            } elseif ($current === 'Dikonfirmasi') {
                                echo '<option value="Dikonfirmasi" selected>Dikonfirmasi</option>';
                                echo '<option value="Batal">Batal</option>';
                                echo '<option value="Selesai">Selesai</option>';
                            } else {
                                echo "<option selected>$current</option>";
                            }
                            ?>
                        </select>

                        <textarea name="tindakan" class="form-control" placeholder="Tindakan (jika selesai)" <?= $disabled ? 'readonly' : '' ?>></textarea>
                        <input type="number" name="biaya" class="form-control" placeholder="Biaya (Rp)" <?= $disabled ? 'readonly' : '' ?>>

                        <button type="submit" name="update_status" class="btn btn-primary btn-sm mt-1" <?= $disabled ? 'disabled' : '' ?>>Update</button>

                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
<div>   
</html>
