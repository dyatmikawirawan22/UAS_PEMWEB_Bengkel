<?php
$host='localhost';
$dbname='bengkel_punjung';
$user='root';
$pass='';
try{
    $pdo=new PDO("mysql:host=$host;dbname=$dbname",$user,$pass);
    $pdo->serAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Koneksi gagal: ".$e->getMessage());
}
?>