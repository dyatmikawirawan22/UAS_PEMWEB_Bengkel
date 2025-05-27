<?php
session_start();
include '../includes/db.php'; // pastikan file ini ada dan benar

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = htmlspecialchars($_POST['nama_user']);
    $email = htmlspecialchars($_POST['email_user']);
    $password = $_POST['password_user'];
    $konfirmasi = $_POST['konfirmasi_password'];

    // Validasi
    if ($password !== $konfirmasi) {
        $error = "Password dan konfirmasi tidak cocok.";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE email_user = '$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Email sudah terdaftar.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (nama_user, email_user, password_user, role_user) 
                      VALUES ('$nama', '$email', '$hash', 'pelanggan')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $success = "Pendaftaran berhasil. <a href='login.php'>Login di sini</a>";
            } else {
                $error = "Terjadi kesalahan: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Punjung Rejeki Motor</title>
</head>
<body>
    <h2>Form Pendaftaran Pengguna</h2>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <form action="" method="POST">
        <label>Nama Lengkap:</label><br>
        <input type="text" name="nama_user" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email_user" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password_user" required><br><br>

        <label>Konfirmasi Password:</label><br>
        <input type="password" name="konfirmasi_password" required><br><br>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>
