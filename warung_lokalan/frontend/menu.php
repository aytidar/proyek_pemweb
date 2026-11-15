<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header('Location: ../backend/dashboard.php');
    exit();
}

require_once '../backend/koneksi.php';

$filter = $_GET['kategori'] ?? 'semua';
$filter = in_array($filter, ['makanan', 'minuman', 'semua']) ? $filter : 'semua';

if ($filter === 'semua') {
    $result = $conn->query("SELECT * FROM menu WHERE tersedia = 1 ORDER BY kategori, nama");
} else {
    $stmt = $conn->prepare("SELECT * FROM menu WHERE tersedia = 1 AND kategori = ? ORDER BY nama");
    $stmt->bind_param('s', $filter);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
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
                    <li class="nav-item"><a class="nav-link active" href="menu.php">Menu</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="reservasi.php">Reservasi</a></li>
                        <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
                        <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
                        <li class="nav-item ms-2"><a class="nav-link btn-logout" href="../backend/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item ms-2"><a class="nav-link btn-warung" href="login.php" style="font-size:0.9rem;padding:7px 20px;">Masuk</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div style="background:var(--hijau-tua);padding:40px 0 30px;color:white;text-align:center;">
        <h2 style="font-weight:700;">🍴 Daftar Menu</h2>
        <p style="opacity:0.85;">Pilihan makanan dan minuman tersedia hari ini</p>
    </div>

    <div class="page-content" style="background:var(--krem);">
        <div class="container">

            <div class="d-flex justify-content-center gap-2 mb-4">
                <a href="menu.php?kategori=semua"
                    class="<?= $filter === 'semua' ? 'btn-warung' : 'btn-warung-outline' ?>">
                    Semua
                </a>
                <a href="menu.php?kategori=makanan"
                    class="<?= $filter === 'makanan' ? 'btn-warung' : 'btn-warung-outline' ?>">
                    🍽️ Makanan
                </a>
                <a href="menu.php?kategori=minuman"
                    class="<?= $filter === 'minuman' ? 'btn-warung' : 'btn-warung-outline' ?>">
                    🥤 Minuman
                </a>
            </div>

            <div class="row g-4">
                <?php if ($result && $result->num_rows > 0):
                    while ($m = $result->fetch_assoc()): ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="card-menu">
                                <?php if (!empty($m['gambar']) && file_exists('images/' . $m['gambar'])): ?>
                                    <img src="images/<?= htmlspecialchars($m['gambar']) ?>"
                                        alt="<?= htmlspecialchars($m['nama']) ?>"
                                        style="width:100%;height:150px;object-fit:cover;">
                                <?php else: ?>
                                    <div class="card-img-placeholder">
                                        <?= $m['kategori'] === 'makanan' ? '🍽️' : '🥤' ?>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title mb-0"><?= htmlspecialchars($m['nama']) ?></h6>
                                        <span class="badge-kategori badge-<?= $m['kategori'] ?>">
                                            <?= ucfirst($m['kategori']) ?>
                                        </span>
                                    </div>
                                    <p class="card-text"><?= htmlspecialchars($m['deskripsi']) ?></p>
                                    <div class="harga-menu mt-2">Rp <?= number_format($m['harga'], 0, ',', '.') ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                else: ?>
                    <div class="col-12 text-center py-5 text-muted">
                        <div style="font-size:3rem;">😔</div>
                        <p>Belum ada menu tersedia saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="text-center mt-5 p-4 content-card">
                    <h5 class="fw-bold" style="color:var(--hijau-tua);">Ingin Memesan Meja?</h5>
                    <p class="text-muted">Login atau daftar akun untuk membuat reservasi.</p>
                    <a href="login.php" class="btn-warung me-2">Masuk</a>
                    <a href="register.php" class="btn-warung-outline">Daftar</a>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <footer class="footer-warung">
        <p>&copy; <?= date('Y') ?> Warung Lokalan</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
</body>

</html>