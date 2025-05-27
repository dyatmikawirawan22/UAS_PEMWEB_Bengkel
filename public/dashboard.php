<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
echo "Selamat datang, ".$_SESSION['user']['name']."<br>";
echo "Anda login sebagai: ".$_SESSION['user']['role']."<br><br>";
if($_SESSION['user']['role']=='admin') {
    echo "<a href='admin_page.php'>Halaman Admin</a><br>";
}else{
    echo "<a href='booking.php'>Booking Servis</a><br>";
}
echo "<a href='logout.php'>Logout</a>";