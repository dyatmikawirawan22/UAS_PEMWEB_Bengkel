<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email_user']);
    $password = $_POST['password_user'];

    // Cek apakah email terdaftar
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email_user = '$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password_user'])) {
        // Login berhasil
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama_user'] = $user['nama_user'];
        $_SESSION['role_user'] = $user['role_user'];

        // Arahkan semua ke index
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Email atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Punjung Rejeki Motor</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <?php if (isset($GET['logout']) && $_GET['logout'] == 'sukses'): ?>
        <p style="color: green;">Anda berhasil logout.</p>
    <?php endif; ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'login_dulu'): ?>
        <p style="color:red;">Silakan login untuk mengakses fitur tersebut.</p>
    <?php endif; ?>


    <form action="" method="POST">
        <label>Email:</label><br>
        <input type="email" name="email_user" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password_user" required><br><br>

        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</body>
</html>
