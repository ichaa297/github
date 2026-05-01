<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = htmlspecialchars($_SESSION['user']);
// determine photo path: prefer sample-bday with common extensions, fallback to inline SVG
$photoRel = '';
$imgDir = __DIR__ . '/../assets/img/';
$candidates = ['sample-bday.jpg','sample-bday.jpeg','sample-bday.png'];
foreach ($candidates as $c) {
    if (file_exists($imgDir . $c)) {
        $photoRel = '../assets/img/' . $c;
        break;
    }
}
if (!$photoRel) {
    // inline SVG placeholder (circular gradient)
    $svg = "<svg xmlns='http://www.w3.org/2000/svg' width='400' height='400' viewBox='0 0 400 400'><defs><linearGradient id='g' x1='0' x2='1'><stop stop-color='%23ffd6e6' offset='0'/><stop stop-color='%23ff9fd6' offset='1'/></linearGradient></defs><rect width='100%' height='100%' fill='url(%23g)' rx='200' ry='200'/></svg>";
    $photoRel = 'data:image/svg+xml;utf8,' . rawurlencode($svg);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Ulang Tahun</title>
    <link rel="stylesheet" href="../assets/css/bday.css">
    <link rel="icon" href="../assets/img/sample-bday.jpeg">
</head>
<body class="bday-page">
    <div class="topbar">
        <h2>Ucapan Spesial</h2>
        <div class="controls">
            <button id="music-toggle" class="icon">🔊</button>
            <a href="logout.php" class="btn small">Keluar</a>
        </div>
    </div>

    <main class="wrap">
        <section class="center">
            
            <div class="cake-wrap">
                <div class="cake">
                    <!-- order top -> bottom for flex stacking -->
                    <div class="layer layer4"></div>
                    <div class="layer layer3"></div>
                    <div class="layer layer2"></div>
                    <div class="layer layer1"></div>
                    <div class="candle">🕯️</div>
                </div>
            </div>
        </section>

        <section class="center">
            <!-- Simplified card: photo + message -->
            <div class="card-preview" id="card-preview">
                <img class="card-photo" src="<?php echo $photoRel; ?>" alt="Foto ucapan">
                <h4>Untuk: <?php echo htmlspecialchars(ucfirst($user)); ?></h4>
                <h3 class="card-title">Selamat ulang tahun</h3>
                <div class="card-text">
                    <p>Terimakasih sudah menjadi teman pertama aku di perkuliahan. makasih sudah selalu ada untuk aku, jadi cantika yang aku kenal seperti dulu selamanya ya, jangan berubah jadi orang yang berbeda, semoga kita bisa bareng terus sampai lulus nanti ya, dan semoga tuhan selalu melindungi kamu, love you babe wish you all the best.</p>
                </div>
            </div>
        </section>
    </main>

    <audio id="bg-music" loop>
        <source src="../assets/music/happy-birthday.mp3" type="audio/mpeg">
    </audio>

    <script src="../assets/js/bday.js"></script>
</body>
</html>
