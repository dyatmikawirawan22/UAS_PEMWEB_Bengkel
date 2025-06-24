<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role_user'] !== 'pelanggan') {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$password = $_POST['password'] ?? '';
$konfirmasi = $_POST['konfirmasi'] ?? '';

if (empty($password) || empty($konfirmasi)) {
    header("Location: ../profile.php?error=Isi kedua kolom password.");
    exit;
}

if ($password !== $konfirmasi) {
    header("Location: ../profile.php?error=Password dan konfirmasi tidak sama.");
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET password_user = ? WHERE id_user = ?");
$stmt->bind_param("si", $hashed, $id_user);

if ($stmt->execute()) {
    header("Location: ../profile.php?info=Password berhasil diperbarui.");
} else {
    header("Location: ../profile.php?error=Gagal memperbarui password.");
}
exit;
