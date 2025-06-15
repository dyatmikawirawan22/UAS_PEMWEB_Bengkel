<?php
session_start();
require '../../includes/db.php';

$user1 = intval($_POST['user1']);
$user2 = intval($_POST['user2']);

$stmt = $conn->prepare("SELECT * FROM chat_messages WHERE (id_pengirim = ? AND id_penerima = ?) OR (id_pengirim = ? AND id_penerima = ?) ORDER BY waktu_kirim ASC");
$stmt->bind_param("iiii", $user1, $user2, $user2, $user1);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $class = ($row['id_pengirim'] == $user1) ? 'you' : 'other';
    echo '<div class="chat-message ' . $class . '"><div class="text">' . htmlspecialchars($row['isi_pesan']) . '</div></div>';
}
?>