<?php
$host = "localhost";
$user = "root"; // Default KSWEB
$pass = "";     // Default KSWEB kosong
$db   = "db_game";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
