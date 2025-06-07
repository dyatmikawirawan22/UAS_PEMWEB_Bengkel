<?php
session_start();
include 'koneksi.php';
include 'auth.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk Sparepart</title>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/fontawesome/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Daftar Produk Sparepart</h4>
        </div>
        <div class="card-body">
            <?php if (isAdmin()): ?>
                <div class="mb-3 text-end">
                    <a href="produk_create.php" class="btn btn-success"><i class="fas fa-plus me-1"></i>Tambah Produk</a>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <?php if (isAdmin()): ?>
                                <th>Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM produk");
                        while($row = mysqli_fetch_assoc($result)):
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                            <td><?= htmlspecialchars($row['kategori_produk']) ?></td>
                            <td class="text-center"><?= $row['stok_produk'] ?></td>
                            <td>Rp <?= number_format($row['harga_produk'], 0, ',', '.') ?></td>
                            <?php if (isAdmin()): ?>
                            <td class="text-center">
                                <a href="produk_edit.php?id=<?= $row['id_produk'] ?>" class="btn btn-warning btn-sm me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="produk_delete.php?id=<?= $row['id_produk'] ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endwhile; ?>
                        <?php if (mysqli_num_rows($result) === 0): ?>
                        <tr>
                            <td colspan="<?= isAdmin() ? 5 : 4 ?>" class="text-center text-muted">Tidak ada data produk.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-3">
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-home me-1"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
