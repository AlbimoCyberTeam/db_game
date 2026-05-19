<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Control Mode</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 15px; background: #eceff1; color: #333; }
        h2 { text-align: center; color: #2c3e50; text-transform: uppercase; letter-spacing: 1px; }
        
        /* Box Tambah User */
        .card { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 20px; border-top: 4px solid #27ae60; }
        .card h4 { margin-top: 0; color: #555; margin-bottom: 10px; }
        input[type="text"] { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; margin-bottom: 10px; font-size: 14px; }
        
        /* Tabel */
        .table-container { background: #fff; border-radius: 12px; overflow-x: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; min-width: 400px; }
        th { background: #2c3e50; color: #fff; padding: 15px; font-size: 12px; text-transform: uppercase; }
        td { padding: 12px 10px; border-bottom: 1px solid #eee; text-align: center; font-size: 13px; vertical-align: middle; }
        
        /* Tombol & Aksi */
        .btn-group { display: flex; flex-direction: column; gap: 5px; align-items: center; }
        .btn { width: 85px; padding: 8px 0; border: none; border-radius: 6px; color: #fff; font-weight: bold; cursor: pointer; font-size: 11px; transition: 0.2s; }
        .btn:active { transform: scale(0.92); }
        
        .gacor { background: #27ae60; }
        .normal { background: #2980b9; }
        .rungkad { background: #c0392b; }
        .simpan { background: #2c3e50; width: 100%; font-size: 14px; padding: 12px; margin-top: 5px; }
        .hapus-link { color: #e74c3c; font-size: 11px; margin-top: 8px; text-decoration: none; font-weight: bold; }
        
        /* Status Label */
        .status-label { font-weight: bold; padding: 4px 10px; border-radius: 20px; font-size: 10px; display: inline-block; }
        .status-gacor { background: #e8f5e9; color: #27ae60; border: 1px solid #27ae60; }
        .status-normal { background: #e3f2fd; color: #2980b9; border: 1px solid #2980b9; }
        .status-rungkad { background: #ffeea1; color: #c0392b; border: 1px solid #c0392b; }
    </style>
</head>
<body>

    <center>
        <img src="https://f.top4top.io/p_3768qpyvp7.jpg" width="220" style="border-radius: 10px; margin-top: 10px;">
    </center>

    <h2>Control Panel User</h2>
    
    <?php
if (isset($_GET['pesan'])) {
    $p = $_GET['pesan'];
    if ($p == "berhasil") echo "<p style='color:green; text-align:center;'>✅ Status berhasil diperbarui!</p>";
    if ($p == "user_ditambah") echo "<p style='color:green; text-align:center;'>✅ User baru berhasil disimpan!</p>";
    if ($p == "hapus") echo "<p style='color:red; text-align:center;'>🗑️ User berhasil dihapus!</p>";
}
?>
    
    <div style="text-align:center; margin-bottom:20px;">
        <a href="logout.php" style="color:#c0392b; font-size:13px; text-decoration:none; font-weight:bold;">[ KELUAR LOGOUT ]</a>
    </div>

    <div class="card">
        <h4>+ Tambah User Baru</h4>
        <!-- PASTIKAN ACTION INI SESUAI NAMA FILE ANDA -->
        <form method="POST" action="user.php">
            <input type="text" name="game_link" placeholder="Tempel link game di sini..." required>
            <button type="submit" class="btn gacor simpan">SIMPAN DATA USER</button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Link Game</th>
                    <th>Status</th>
                    <th>Kontrol</th>
                </tr>
            </thead>
            <<!-- Bagian Tbody yang sudah diperbaiki -->
<tbody>
    <?php
    $sql = "SELECT * FROM users ORDER BY id DESC";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $mode = strtolower($row['config_mode'] ?? 'normal');
            $safe_link = htmlspecialchars($row['game_link']); // Keamanan XSS
            echo "<tr>
                <td><b>#{$row['id']}</b></td>
                <td style='text-align:left; font-size:11px; color:#666; max-width:150px; word-wrap:break-word;'>{$safe_link}</td>
                <td><span class='status-label status-{$mode}'>".strtoupper($mode)."</span></td>
                <td>
                    <form method='POST' action='update.php' class='btn-group'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button name='mode' value='gacor' class='btn gacor'>GACOR</button>
                        <button name='mode' value='normal' class='btn normal'>NORMAL</button>
                        <button name='mode' value='rungkad' class='btn rungkad'>RUNGKAD</button>
                        <a href='hapus.php?id={$row['id']}' class='hapus-link' onclick='return confirm(\"Hapus user ini?\")'>HAPUS USER</a>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Belum ada data user.</td></tr>";
    }
    ?>
</tbody>
        </table>
    </div>

</body>
</html>
