<?php
include 'koneksi.php';
// Mencari berdasarkan Link, bukan ID
if (isset($_GET['link'])) {
    $link = $_GET['link'];
    $stmt = $conn->prepare("SELECT config_mode FROM users WHERE game_link = ?");
    $stmt->bind_param("s", $link);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo $row['config_mode'];
    } else {
        echo "normal";
    }
}
?>
