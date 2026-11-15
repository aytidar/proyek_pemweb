<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error   = htmlspecialchars($_GET['error']);
$success = htmlspecialchars($_GET['success']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card" style="max-width:520px;">

            <div class="brand-logo">
                <span class="logo-icon">🍽️</span>
                <h2>Warung Lokalan</h2>
            </div>

            <h3>Buat Akun</h3>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-warung alert-auto-hide">⚠️ <?= $error ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success alert-warung alert-auto-hide">✅ <?= $success ?></div>
            <?php endif; ?>

            <form action="../backend/proses_register.php" method="POST" class="form-warung">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama" name="nama"
                        placeholder="Contoh: Sakamoto" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="nama@gmail.com" required>
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="telepon" name="telepon"
                        placeholder="08xxxxxxxxxx">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Wajib 8 karakter" required minlength="8" maxlength="8">
                </div>
                <div class="mb-4">
                    <label for="konfirmasi_password" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password"
                        placeholder="Ulangi password" required minlength="8" maxlength="8">
                </div>
                <button type="submit" class="btn-warung w-100 py-2">Daftar Sekarang</button>
            </form>

            <p class="text-center mt-3 text-muted small">
                Sudah punya akun?
                <a href="login.php" style="color:var(--hijau-tua);font-weight:600;">Masuk di sini</a>
            </p>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
</body>

</html>