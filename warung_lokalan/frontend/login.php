<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: ../backend/dashboard.php');
    } else {
        header('Location: index.php');
    }
    exit();
}

$error   = htmlspecialchars($_GET['error']);
$success = htmlspecialchars($_GET['success']);

$cookie_email = htmlspecialchars($_COOKIE['wl_email']);
$cookie_nama = htmlspecialchars($_COOKIE['wl_nama']);

if ($cookie_nama) {
    setcookie('wl_nama', '', time() - 3600, '/');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">

            <div class="brand-logo">
                <span class="logo-icon">🍽️</span>
                <h2>Warung Lokalan</h2>
                <p class="text-muted small">Sistem Reservasi Meja Online</p>
            </div>

            <h3>Masuk</h3>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-warung alert-auto-hide">
                    ⚠️ <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if ($cookie_nama && !$success): ?>
                <div class="alert alert-success alert-warung alert-auto-hide">
                    👋 Halo, <strong><?= $cookie_nama ?></strong>! Akun Anda berhasil dibuat. Silakan login.
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success alert-warung alert-auto-hide">
                    ✅ <?= $success ?>
                </div>
            <?php endif; ?>

            <form action="../backend/proses_login.php" method="POST" class="form-warung">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>

                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="nama@gmail.com" value="<?= $cookie_email ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" minlength="8" maxlength="8"
                        placeholder="Masukkan password" required>
                </div>

                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="ingat_saya" id="ingat_saya"
                            <?= $cookie_email ? 'checked' : '' ?>>
                        <label class="form-check-label text-muted small" for="ingat_saya">Ingat Saya</label>
                    </div>
                </div>
                <button type="submit" class="btn-warung w-100 py-2">Masuk</button>
            </form>

            <p class="text-center mt-3 text-muted small">
                Belum punya akun?
                <a href="register.php" style="color:var(--hijau-tua);font-weight:600;">Daftar di sini</a>
            </p>
            <p class="text-center">
                <a href="index.php" class="text-muted small">← Kembali ke Beranda</a>
            </p>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
</body>

</html>