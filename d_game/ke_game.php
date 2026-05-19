<?php
include 'koneksi.php';

// Pastikan ID sesuai dengan yang ada di panel kontrol Anda
$id_game = 2; 

$stmt = $conn->prepare("SELECT game_link, config_mode FROM users WHERE id = ?");
$stmt->bind_param("i", $id_game);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$status = strtolower($data['config_mode'] ?? 'normal');
$link_tujuan = $data['game_link'] ?? 'https://mentotomewah.com';

// Logika Tampilan berdasarkan Status
if ($status == "gacor") {
    $target_persen = rand(94, 98); 
    $pesan = "SERVER STATUS: [ GACOR MODE ACTIVE ]";
    $warna = "#00ff00"; // Hijau
} elseif ($status == "rungkad") {
    $target_persen = rand(10, 25); 
    $pesan = "SERVER STATUS: [ UNDER MAINTENANCE ]";
    $warna = "#ff0000"; // Merah
} else {
    $target_persen = rand(50, 70); 
    $pesan = "SERVER STATUS: [ STABLE / NORMAL ]";
    $warna = "#00bcff"; // Biru
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winrate Checker - Mentoto</title>
    <style>
        body { background-color: #050505; color: white; font-family: 'Courier New', monospace; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { text-align: center; padding: 30px; border: 2px solid <?php echo $warna; ?>; border-radius: 20px; background: rgba(20, 20, 20, 0.9); box-shadow: 0 0 25px <?php echo $warna; ?>44; width: 85%; max-width: 380px; }
        .img-header { width: 100px; border-radius: 50%; border: 2px solid <?php echo $warna; ?>; margin-bottom: 15px; filter: drop-shadow(0 0 5px <?php echo $warna; ?>); }
        h2 { margin: 10px 0; font-size: 1.4rem; color: <?php echo $warna; ?>; text-shadow: 0 0 5px <?php echo $warna; ?>; }
        .status-text { font-size: 11px; margin-bottom: 20px; letter-spacing: 1px; color: #ccc; }
        .winrate-circle { font-size: 70px; font-weight: bold; margin: 15px 0; color: <?php echo $warna; ?>; text-shadow: 0 0 15px <?php echo $warna; ?>; }
        .progress-bar { width: 100%; background: #222; height: 8px; border-radius: 5px; margin-bottom: 25px; overflow: hidden; }
        .progress-fill { height: 100%; background: <?php echo $warna; ?>; width: 0%; transition: width 2s ease-out; }
        .btn-gas { display: block; padding: 16px; background-color: <?php echo $warna; ?>; color: #000; text-decoration: none; font-weight: bold; border-radius: 8px; transition: 0.3s; text-transform: uppercase; letter-spacing: 1px; }
        .btn-gas:active { transform: scale(0.95); }
    </style>
</head>
<body>

<div class="container">
    <img src="https://top4top.io" class="img-header">
    <h2>MENTOTO CHECKER</h2>
    <div class="status-text"><?php echo $pesan; ?></div>
    
    <div style="font-size: 12px; color: #888;">PROBABILITAS KEMENANGAN:</div>
    <div class="winrate-circle" id="counter">0%</div>

    <div class="progress-bar">
        <div class="progress-fill" id="bar"></div>
    </div>

    <a href="<?php echo $link_tujuan; ?>" class="btn-gas">KLIK UNTUK MAIN</a>
    <p style="font-size: 9px; margin-top: 15px; color: #444;">SYSTEM SECURED BY ANONYMOUS</p>
</div>

<script>
    // Animasi Angka dan Progress Bar
    let target = <?php echo $target_persen; ?>;
    let current = 0;
    let counter = document.getElementById('counter');
    let bar = document.getElementById('bar');

    let interval = setInterval(() => {
        if (current >= target) {
            clearInterval(interval);
        } else {
            current++;
            counter.innerText = current + "%";
            bar.style.width = current + "%";
        }
    }, 20); // Kecepatan animasi (semakin kecil semakin cepat)
</script>

</body>
</html>
