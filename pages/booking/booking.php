<?php
session_start();
include '../../includes/db.php';

if (!isset($_SESSION['id_user']) || !isset($_SESSION['nama_user'])) {
    header("Location: ../../auth/login.php?pesan=Silahkan login terlebih dahulu untuk booking servis");
    exit();
}

$nama_user = $_SESSION['nama_user'];
$id_user = $_SESSION['id_user'];
$pesanError = '';

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $merk = $_POST['merk'];
    $tipe = $_POST['tipe'];
    $nopol = $_POST['nopol'];
    $tahun = $_POST['tahun'];
    $jenis_servis = $_POST['jenis_servis'];
    $keluhan = $_POST['keluhan'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $status = 'Menunggu Konfirmasi';

    $query = mysqli_query($conn, "INSERT INTO bookings 
        (id_user, jenis_kendaraan_booking, tipe_kendaraan_booking, nopol_booking, tahun_booking, jenis_servis_booking, keluhan_booking, tanggal_booking, waktu_booking, status_booking)
        VALUES 
        ('$id_user', '$jenis_kendaraan', '$tipe', '$nopol', '$tahun', '$jenis_servis', '$keluhan', '$tanggal', '$waktu', '$status')");

    if ($query) {
        header("Location: ../../index.php?pesan=Booking berhasil");
        exit();
    } else {
        $pesanError = "Gagal melakukan booking: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Booking Servis - Punjung Rejeki Motor</title>
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

        .booking-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            border-left: 5px solid var(--primary);
            overflow: hidden;
            margin-top: 30px;
        }

        .booking-header {
            background: linear-gradient(90deg, var(--dark), var(--primary));
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
        }

        .form-label {
            font-weight: bold;
            color: var(--dark);
        }

        .btn-submit {
            background: linear-gradient(45deg, var(--primary), #f1c40f);
            border: none;
            padding: 10px 25px;
            font-weight: bold;
            border-radius: 50px;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }

        .bike-icon {
            font-size: 3rem;
            color: var(--primary);
            text-align: center;
            margin-bottom: 20px;
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
        <a href="../../profile.php"><i class="fas fa-user me-2"></i><?= htmlspecialchars($nama_user) ?></a>
        <a href="../../auth/logout.php" style="background-color: var(--secondary); color: white;"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="booking-card">
                <div class="booking-header">
                    <h3 class="mb-0"><i class="fas fa-calendar-check me-2"></i> FORM BOOKING SERVIS</h3>
                </div>
                <div class="p-4">
                    <?php if ($pesanError): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($pesanError) ?></div>
                    <?php endif; ?>

                    <div class="bike-icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($nama_user) ?>" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Merk Motor</label>
                                <select class="form-select" name="merk" required>
                                    <option value="">Pilih Merk Motor</option>
                                    <option value="Honda">Honda</option>
                                    <option value="Yamaha">Yamaha</option>
                                    <option value="Suzuki">Suzuki</option>
                                    <option value="Kawasaki">Kawasaki</option>
                                    <option value="Vespa">Vespa</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipe Motor</label>
                                <input type="text" class="form-control" name="tipe" placeholder="Contoh: Beat, Vario, NMax" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Polisi</label>
                                <input type="text" class="form-control" name="nopol" placeholder="Contoh: B 1234 ABC" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Pembuatan</label>
                                <input type="number" class="form-control" name="tahun" min="1980" max="<?= date('Y') ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Servis</label>
                            <select class="form-select" name="jenis_servis" required>
                                <option value="">Pilih Jenis Servis</option>
                                <option value="Servis Ringan">Servis Ringan (Ganti Oli & Check Standar)</option>
                                <option value="Servis Berkala">Servis Berkala (Lengkap + Tune Up)</option>
                                <option value="Servis Besar">Servis Besar (Overhaul Mesin)</option>
                                <option value="Perbaikan">Perbaikan (Ada Kerusakan/Keluhan)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keluhan/Keterangan</label>
                            <textarea class="form-control" name="keluhan" rows="3" placeholder="Jelaskan keluhan atau keterangan tambahan"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Servis</label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Waktu Servis</label>
                                <select class="form-select" name="waktu" required>
                                    <option value="">Pilih Waktu</option>
                                    <option value="08:00-10:00">08:00 - 10:00</option>
                                    <option value="10:00-12:00">10:00 - 12:00</option>
                                    <option value="13:00-15:00">13:00 - 15:00</option>
                                    <option value="15:00-17:00">15:00 - 17:00</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="jenis_kendaraan" value="Motor">

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-paper-plane me-2"></i> BOOKING SEKARANG
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelector('input[name="tanggal"]').min = new Date().toISOString().split("T")[0];
    document.querySelector('form').addEventListener('submit', function () {
        document.querySelector('.btn-submit').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
    });
</script>

</body>
</html>
