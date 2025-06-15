<?php
session_start();
require '../../includes/db.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$role_user = $_SESSION['role_user'];
$nama_user = $_SESSION['nama_user'];

// Cari admin (untuk pelanggan)
if ($role_user === 'pelanggan') {
    $admin = mysqli_query($conn, "SELECT id_user FROM users WHERE role_user = 'admin' LIMIT 1");
    $admin_data = mysqli_fetch_assoc($admin);
    $id_admin = $admin_data['id_user'];
    $chat_with = $id_admin;
} else {
    // Admin: pilih pelanggan
    $chat_with = isset($_GET['user']) ? intval($_GET['user']) : 0;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Live Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-box {
            height: 400px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .chat-message {
            margin-bottom: 10px;
        }
        .chat-message.you {
            text-align: right;
        }
        .chat-message .text {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 15px;
        }
        .chat-message.you .text {
            background-color: #d1e7dd;
        }
        .chat-message.other .text {
            background-color: #f8d7da;
        }
    </style>
</head>
<body class="container py-4">
    <h3>Live Chat</h3>

    <?php if ($role_user === 'admin'): ?>
        <div class="mb-3">
            <form method="GET" class="form-inline">
                <label class="form-label">Pilih Pelanggan:</label>
                <select name="user" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih --</option>
                    <?php
                    $users = mysqli_query($conn, "SELECT * FROM users WHERE role_user = 'pelanggan'");
                    while ($u = mysqli_fetch_assoc($users)) {
                        $selected = ($chat_with == $u['id_user']) ? 'selected' : '';
                        echo "<option value='{$u['id_user']}' $selected>{$u['nama_user']}</option>";
                    }
                    ?>
                </select>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($chat_with): ?>
        <div id="chat-box" class="chat-box mb-3"></div>

        <form id="form-kirim">
            <input type="hidden" name="id_pengirim" value="<?= $id_user ?>">
            <input type="hidden" name="id_penerima" value="<?= $chat_with ?>">
            <div class="input-group">
                <input type="text" name="isi_pesan" class="form-control" placeholder="Tulis pesan..." required>
                <button class="btn btn-primary" type="submit">Kirim</button>
            </div>
        </form>
    <?php else: ?>
        <p>Silakan pilih pelanggan untuk memulai chat.</p>
    <?php endif; ?>

<script>
function loadChat() {
    const chatBox = document.getElementById('chat-box');
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'load_chat.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        chatBox.innerHTML = this.responseText;
        chatBox.scrollTop = chatBox.scrollHeight;
    };
    xhr.send('user1=<?= $id_user ?>&user2=<?= $chat_with ?>');
}

document.getElementById('form-kirim').addEventListener('submit', function(e) {
    e.preventDefault();
    const data = new FormData(this);
    fetch('kirim_pesan.php', {
        method: 'POST',
        body: data
    }).then(() => {
        this.reset();
        loadChat();
    });
});

setInterval(loadChat, 1000);
loadChat();
</script>
</body>
</html>
