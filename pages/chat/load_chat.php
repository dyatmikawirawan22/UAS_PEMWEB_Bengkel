<?php
session_start();
require '../../includes/db.php';

$user1 = intval($_POST['user1']);
$user2 = intval($_POST['user2']);

$stmt = $conn->prepare("SELECT cm.*, u.nama_user FROM chat_messages cm JOIN users u ON cm.id_pengirim = u.id_user WHERE (cm.id_pengirim = ? AND cm.id_penerima = ?) OR (cm.id_pengirim = ? AND cm.id_penerima = ?) ORDER BY cm.waktu_kirim ASC");
$stmt->bind_param("iiii", $user1, $user2, $user2, $user1);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $class = ($row['id_pengirim'] == $user1) ? 'you' : 'other';
    $time = date('H:i', strtotime($row['waktu_kirim']));
    echo '<div class="chat-message ' . $class . '">';
    echo '<div class="message-content">' . htmlspecialchars($row['isi_pesan']) . '</div>';
    echo '<div class="message-info">' . htmlspecialchars($row['nama_user']) . ' • ' . $time . '</div>';
    echo '</div>';
}
?>
