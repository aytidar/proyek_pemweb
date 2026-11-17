<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header('Location: ../backend/dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-warung">
        <div class="container">
            <a class="navbar-brand" href="index.php">🍽️ Warung Lokalan</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span style="color:white; font-size:1.4rem;">☰</span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu.php">Menu</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="reservasi.php">Reservasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="riwayat.php">Riwayat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profil.php">Profil</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link btn-logout" href="../backend/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-2">
                            <a class="nav-link btn-warung" href="login.php" style="font-size:0.9rem;padding:7px 20px;">Masuk</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <h1>🍽️ Warung Lokalan</h1>
            <p>Nikmati cita rasa masakan rumahan yang otentik.
                <br>Pesan meja Anda sekarang, kami siapkan tempatnya!
            </p>
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="reservasi.php" class="btn-hero">📅 Buat Reservasi</a>
                    <a href="menu.php" class="btn-hero btn-hero-outline">🍴 Lihat Menu</a>
                <?php else: ?>
                    <a href="register.php" class="btn-hero">Daftar Sekarang</a>
                    <a href="menu.php" class="btn-hero btn-hero-outline">🍴 Lihat Menu</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="py-5" style="background:var(--putih);">
        <div class="container">
            <div class="section-title">
                <h2>Mengapa Warung Lokalan?</h2>
                <div class="divider"></div>
                <p>Kami menyajikan pengalaman makan yang nyaman dan berkesan</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <div style="font-size:3rem;margin-bottom:12px;">🏠</div>
                        <h5 class="fw-bold" style="color:var(--hijau-tua);">Suasana Rumahan</h5>
                        <p class="text-muted">Nikmati makan dengan suasana hangat dan nyaman seperti di rumah sendiri.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <div style="font-size:3rem;margin-bottom:12px;">📱</div>
                        <h5 class="fw-bold" style="color:var(--hijau-tua);">Reservasi Online</h5>
                        <p class="text-muted">Pesan meja kapan saja dan dari mana saja hanya dengan beberapa klik.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <div style="font-size:3rem;margin-bottom:12px;">🍲</div>
                        <h5 class="fw-bold" style="color:var(--hijau-tua);">Menu Lezat</h5>
                        <p class="text-muted">Berbagai pilihan makanan dan minuman dengan cita rasa khas lokal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" style="background:var(--krem);">
        <div class="container">
            <div class="section-title">
                <h2>Menu Unggulan</h2>
                <div class="divider"></div>
                <p>Sajian terbaik pilihan pelanggan kami</p>
            </div>
            <?php
            require_once '../backend/koneksi.php';
            $result = $conn->query("SELECT * FROM menu WHERE tersedia = 1 ORDER BY id LIMIT 3");
            ?>
            <div class="row g-4">
                <?php if ($result && $result->num_rows > 0):
                    while ($menu = $result->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card-menu">
                                <?php if (!empty($menu['gambar']) && file_exists('images/' . $menu['gambar'])): ?>
                                    <img src="images/<?= htmlspecialchars($menu['gambar']) ?>"
                                        alt="<?= htmlspecialchars($menu['nama']) ?>"
                                        style="width:100%;height:150px;object-fit:cover;">
                                <?php else: ?>
                                    <div class="card-img-placeholder">
                                        <?= $menu['kategori'] === 'makanan' ? '🍽️' : '🥤' ?>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title mb-0"><?= htmlspecialchars($menu['nama']) ?></h6>
                                        <span class="badge-kategori badge-<?= $menu['kategori'] ?>">
                                            <?= ucfirst($menu['kategori']) ?>
                                        </span>
                                    </div>
                                    <p class="card-text"><?= htmlspecialchars($menu['deskripsi']) ?></p>
                                    <div class="harga-menu mt-2">Rp <?= number_format($menu['harga'], 0, ',', '.') ?></div>
                                </div>
                            </div>
                        </div>
                <?php endwhile;
                endif; ?>
            </div>
            <div class="text-center mt-4">
                <a href="menu.php" class="btn-warung">Lihat Semua Menu</a>
            </div>
        </div>
    </section>

    <section class="py-5" style="background:var(--putih);">
        <div class="container">
            <div class="section-title">
                <h2>Cara Reservasi</h2>
                <div class="divider"></div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-3 text-center">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:60px;height:60px;background:var(--hijau-terang);font-size:1.4rem;font-weight:700;color:var(--hijau-tua);">1</div>
                    <h6 class="fw-bold">Daftar Akun</h6>
                    <p class="text-muted small">Buat akun pelanggan baru secara gratis.</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:60px;height:60px;background:var(--hijau-terang);font-size:1.4rem;font-weight:700;color:var(--hijau-tua);">2</div>
                    <h6 class="fw-bold">Pilih Tanggal & Jam</h6>
                    <p class="text-muted small">Tentukan kapan Anda ingin datang.</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:60px;height:60px;background:var(--hijau-terang);font-size:1.4rem;font-weight:700;color:var(--hijau-tua);">3</div>
                    <h6 class="fw-bold">Kirim Reservasi</h6>
                    <p class="text-muted small">Konfirmasi booking dan tunggu persetujuan.</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:60px;height:60px;background:var(--hijau-terang);font-size:1.4rem;font-weight:700;color:var(--hijau-tua);">4</div>
                    <h6 class="fw-bold">Datang & Nikmati</h6>
                    <p class="text-muted small">Meja Anda sudah siap. Selamat menikmati!</p>
                </div>
            </div>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="text-center mt-4">
                    <a href="register.php" class="btn-warung">Daftar & Reservasi Sekarang</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer-warung">
        <p>&copy; <?= date('Y') ?> Warung Lokalan.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
</body>

</html>