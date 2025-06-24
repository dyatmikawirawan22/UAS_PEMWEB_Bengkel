<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role_user'] !== 'pelanggan') {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$stmt = $conn->prepare("DELETE FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id_user);

if ($stmt->execute()) {
    session_destroy();
    header("Location: ../index.php?pesan=akun_dihapus");
} else {
    header("Location: ../profile.php?error=Gagal menghapus akun.");
}
exit;
