<?php
session_start();
require '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengirim = intval($_POST['id_pengirim']);
    $id_penerima = intval($_POST['id_penerima']);
    $isi_pesan = trim($_POST['isi_pesan']);

    if ($id_pengirim && $id_penerima && $isi_pesan !== '') {
        $stmt = $conn->prepare("INSERT INTO chat_messages (id_pengirim, id_penerima, isi_pesan) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id_pengirim, $id_penerima, $isi_pesan);
        $stmt->execute();
    }
}
?>