<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pelanggan') {
    header('Location: login.php?error=Silakan+login+terlebih+dahulu');
    exit();
}

require_once '../backend/koneksi.php';

$user_id = (int) $_SESSION['user_id'];
$error   = htmlspecialchars($_GET['error']);
$success = htmlspecialchars($_GET['success']);

$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-warung">
        <div class="container">
            <a class="navbar-brand" href="index.php">🍽️ Warung Lokalan</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span style="color:white;font-size:1.4rem;">☰</span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="reservasi.php">Reservasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
                    <li class="nav-item"><a class="nav-link active" href="profil.php">Profil</a></li>
                    <li class="nav-item ms-2"><a class="nav-link btn-logout" href="../backend/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="background:var(--hijau-tua);padding:40px 0 30px;color:white;text-align:center;">
        <h2 style="font-weight:700;">👤 Profil Saya</h2>
        <p style="opacity:0.85;">Kelola informasi akun Anda</p>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="content-card">

                        <div class="text-center mb-4">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width:80px;height:80px;background:var(--hijau-terang);font-size:2.2rem;">
                                👤
                            </div>
                            <h5 class="mt-2 fw-bold" style="color:var(--hijau-tua);">
                                <?= htmlspecialchars($user['nama']) ?>
                            </h5>
                            <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
                        </div>

                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-warung alert-auto-hide">⚠️ <?= $error ?></div>
                        <?php endif; ?>
                        <?php if ($success): ?>
                            <div class="alert alert-success alert-warung alert-auto-hide">✅ <?= $success ?></div>
                        <?php endif; ?>

                        <form action="../backend/proses_edit_profil.php" method="POST" class="form-warung">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama"
                                    value="<?= htmlspecialchars($user['nama']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control"
                                    value="<?= htmlspecialchars($user['email']) ?>" disabled>
                                <small class="text-muted">Email tidak dapat diubah</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" name="telepon"
                                    value="<?= htmlspecialchars($user['telepon'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" rows="2"><?= htmlspecialchars($user['alamat'] ?? '') ?></textarea>
                            </div>

                            <hr class="my-4">
                            <p class="fw-bold small" style="color:var(--hijau-tua);">Ganti Password</p>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control" name="password_baru"
                                    placeholder="Kosongkan jika tidak ingin ganti">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="konfirmasi_password"
                                    placeholder="Ulangi password baru">
                            </div>

                            <button type="submit" class="btn-warung w-100 py-2">Simpan Perubahan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-warung">
        <p>&copy; <?= date('Y') ?> Warung Lokalan</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
</body>

</html>