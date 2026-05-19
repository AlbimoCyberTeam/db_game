<?php
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['game_link'])) {
    $game_link = $_POST['game_link'];
    // Default mode diset 'normal' saat tambah user baru
    $stmt = $conn->prepare("INSERT INTO users (game_link, config_mode) VALUES (?, 'normal')");
    $stmt->bind_param("s", $game_link);
    
    if ($stmt->execute()) {
        header("Location: index.php?pesan=user_ditambah");
        exit();
    } else {
        // Tambahkan ini untuk melihat error jika gagal lagi
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
