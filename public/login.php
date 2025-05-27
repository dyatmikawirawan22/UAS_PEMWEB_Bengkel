<?php
session_start();
require_once '../config/database.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $stmt=$pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user=$stmt->fetch();
    if($user&&password_verify($password,$user['password'])){
        $_SESSION['user']=[
            'id'=>$user['id'],
            'name'=>$user['name'],
            'role'=>$user['role']
        ];
        header("Location: dashboard.php");
        exit;
    }else{
        echo "Email atau password salah.";
    }
}
?>
<form method="post">
    <h2>Login</h2>
    <input type="email"name="email"placeholder="email"required><br>
    <input type="password"name="password"placeholder="Password"required><br>
    <button type="submit">Login</button>
</form>