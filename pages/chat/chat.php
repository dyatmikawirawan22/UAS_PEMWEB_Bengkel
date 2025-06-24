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
    $admin = mysqli_query($conn, "SELECT id_user, nama_user FROM users WHERE role_user = 'admin' LIMIT 1");
    $admin_data = mysqli_fetch_assoc($admin);
    $id_admin = $admin_data['id_user'];
    $nama_admin = $admin_data['nama_user'];
    $chat_with = $id_admin;
    $chat_with_name = $nama_admin;
} else {
    // Admin: pilih pelanggan
    $chat_with = isset($_GET['user']) ? intval($_GET['user']) : 0;
    if ($chat_with) {
        $pelanggan = mysqli_query($conn, "SELECT nama_user FROM users WHERE id_user = $chat_with");
        $pelanggan_data = mysqli_fetch_assoc($pelanggan);
        $chat_with_name = $pelanggan_data['nama_user'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Live Chat - Punjung Rejeki Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #f39c12;
            --secondary: #e74c3c;
            --dark: #2c3e50;
            --light: #ecf0f1;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            background-image: url('../../haha.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 150%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: -1;
        }
        
        .chat-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 20px;
            margin-top: 20px;
        }
        
        .chat-header {
            background: linear-gradient(135deg, var(--dark) 0%, #1a252f 100%);
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            margin-bottom: 20px;
        }
        
        .chat-header h3 {
            margin: 0;
            font-weight: bold;
        }
        
        .chat-box {
            height: 500px;
            overflow-y: auto;
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.1);
        }
        
        .chat-message {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }
        
        .chat-message.you {
            align-items: flex-end;
        }
        
        .chat-message.other {
            align-items: flex-start;
        }
        
        .message-content {
            max-width: 70%;
            padding: 12px 15px;
            border-radius: 18px;
            position: relative;
            word-wrap: break-word;
        }
        
        .chat-message.you .message-content {
            background: linear-gradient(135deg, var(--primary), #f1c40f);
            color: white;
            border-bottom-right-radius: 2px;
        }
        
        .chat-message.other .message-content {
            background: linear-gradient(135deg, #e0e0e0, #f5f5f5);
            color: var(--dark);
            border-bottom-left-radius: 2px;
        }
        
        .message-info {
            font-size: 0.8rem;
            margin-top: 5px;
            color: #777;
        }
        
        .chat-input {
            display: flex;
            gap: 10px;
        }
        
        .chat-input input {
            flex: 1;
            border-radius: 50px;
            padding: 12px 20px;
            border: 2px solid #ddd;
            transition: all 0.3s;
        }
        
        .chat-input input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(243, 156, 18, 0.25);
        }
        
        .chat-input button {
            border-radius: 50px;
            padding: 0 25px;
            background: linear-gradient(135deg, var(--primary), #f1c40f);
            border: none;
            color: white;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .chat-input button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .user-selector {
            margin-bottom: 20px;
        }
        
        .user-selector select {
            border-radius: 50px;
            padding: 10px 15px;
            border: 2px solid #ddd;
        }
        
        .no-chat-selected {
            text-align: center;
            padding: 50px;
            color: #777;
        }
        
        /* Scrollbar styling */
        .chat-box::-webkit-scrollbar {
            width: 8px;
        }
        
        .chat-box::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .chat-box::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }
        
        .chat-box::-webkit-scrollbar-thumb:hover {
            background: #e67e22;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="chat-container">
        <div class="chat-header d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-comments me-2"></i> Live Chat</h3>
            <div class="d-flex align-items-center">
                <span class="me-3">Halo, <strong><?= htmlspecialchars($nama_user) ?></strong></span>
                <a href="../../admin/admin_dashboard.php" class="btn btn-sm btn-outline-light"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            </div>
        </div>

        <?php if ($role_user === 'admin'): ?>
            <div class="user-selector">
                <form method="GET" class="form-inline">
                    <label class="form-label me-2"><i class="fas fa-user-friends me-1"></i> Pilih Pelanggan:</label>
                    <select name="user" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Pelanggan --</option>
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
            <div class="chat-info mb-3 p-3 bg-light rounded">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i> Sedang chat dengan: <strong><?= htmlspecialchars($chat_with_name) ?></strong></h5>
            </div>
            
            <div id="chat-box" class="chat-box"></div>

            <form id="form-kirim" class="chat-input">
                <input type="hidden" name="id_pengirim" value="<?= $id_user ?>">
                <input type="hidden" name="id_penerima" value="<?= $chat_with ?>">
                <input type="text" name="isi_pesan" class="form-control" placeholder="Tulis pesan Anda..." required>
                <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane me-1"></i> Kirim</button>
            </form>
        <?php else: ?>
            <div class="no-chat-selected">
                <i class="fas fa-comment-slash fa-3x mb-3" style="color: var(--primary);"></i>
                <h4>Silakan pilih pelanggan untuk memulai chat</h4>
                <p class="text-muted">Pilih nama pelanggan dari dropdown di atas</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function loadChat() {
    if (!<?= $chat_with ? 1 : 0 ?>) return;
    
    const chatBox = document.getElementById('chat-box');
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'load_chat.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.status === 200) {
            chatBox.innerHTML = this.responseText;
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    };
    xhr.send('user1=<?= $id_user ?>&user2=<?= $chat_with ?>');
}

document.getElementById('form-kirim')?.addEventListener('submit', function(e) {
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

// Refresh chat setiap 2 detik
setInterval(loadChat, 2000);
loadChat();
</script>
</body>
</html>
