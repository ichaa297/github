<?php
session_start();

// Simple demo login (hardcoded). Username: cantika, Password: 0804
$error = '';
if (isset($_POST['login'])) {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');
    if ($user === 'cantika' && $pass === '0804') {
        $_SESSION['user'] = $user;
        header('Location: welcome.php');
        exit;
    }
    $error = 'Username atau password salah. Coba: cantika / 0804';
}

// If already logged in, go straight to welcome
if (isset($_SESSION['user'])) {
    header('Location: welcome.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - Ucapan Ulang Tahun</title>
    <link rel="stylesheet" href="../assets/css/bday.css">
</head>
<body class="bday-login">
    <main class="login-card">
        <h1>Selamat Datang 🎉</h1>

        <?php if ($error): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" class="form-login" autocomplete="off">
            <label>Username</label>
            <input type="text" name="username" placeholder="cantika" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="0804" required>

            <button type="submit" name="login" class="btn">Masuk</button>
        </form>


    </main>
</body>
</html>
