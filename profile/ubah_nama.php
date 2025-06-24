<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role_user'] !== 'pelanggan') {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$nama = trim($_POST['nama'] ?? '');

if ($nama === '') {
    header("Location: ../profile.php?error=Nama tidak boleh kosong.");
    exit;
}

$stmt = $conn->prepare("UPDATE users SET nama_user = ? WHERE id_user = ?");
$stmt->bind_param("si", $nama, $id_user);

if ($stmt->execute()) {
    $_SESSION['nama_user'] = $nama;
    header("Location: ../profile.php?info=Nama berhasil diperbarui.");
} else {
    header("Location: ../profile.php?error=Gagal memperbarui nama.");
}
exit;
