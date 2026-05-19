<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['mode'])) {
    $id = $_POST['id'];
    $mode = $_POST['mode'];

    // Menyiapkan query update
    $stmt = $conn->prepare("UPDATE users SET config_mode = ? WHERE id = ?");
    
    // "si" artinya string (mode) dan integer (id)
    $stmt->bind_param("si", $mode, $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?pesan=berhasil");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error untuk mempermudah perbaikan
        echo "Gagal memperbarui data: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
