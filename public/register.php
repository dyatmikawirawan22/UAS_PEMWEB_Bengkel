<?php
require_once '../config/database.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
    $role=$_POST['role'];
    $stmt=$pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    if($stmt->execute([$name,$email,$password,$role])){
        header("Location: login.php?success=1");
        exit;
    }else{
        echo"Gagal registrasi.";
    }
}
?>
<form method="post">
    <h2>Registrasi</h2>
    <input typr="text" name="name" placeholder="Nama" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="role">
        <option value="pelanggan">Pelanggan</option>
        <option value="admin">Admin</option>
</selected><br>
<button type="submit">Daftar</button>
</form>