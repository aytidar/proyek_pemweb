<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pelanggan') {
    header('Location: login.php?error=Silakan+login+terlebih+dahulu');
    exit();
}

require_once '../backend/koneksi.php';

$user_id = $_SESSION['user_id'];
$success = htmlspecialchars($_GET['success'] ?? '');

$stmt = $conn->prepare(
    "SELECT * FROM reservasi WHERE user_id = ? ORDER BY created_at DESC"
);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$reservasi_list = $stmt->get_result();
$stmt->close();

function badgeStatus($status)
{
    $map = [
        'menunggu' => 'status-menunggu',
        'diterima' => 'status-diterima',
        'ditolak'  => 'status-ditolak',
    ];
    $label = [
        'menunggu' => '⏳ Menunggu',
        'diterima' => '✅ Diterima',
        'ditolak'  => '❌ Ditolak',
    ];
    $class = $map[$status] ?? 'status-menunggu';
    $text  = $label[$status] ?? ucfirst($status);
    return "<span class=\"$class\">$text</span>";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat</title>
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
                    <li class="nav-item"><a class="nav-link active" href="riwayat.php">Riwayat</a></li>
                    <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
                    <li class="nav-item ms-2"><a class="nav-link btn-logout" href="../backend/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="background:var(--hijau-tua);padding:40px 0 30px;color:white;text-align:center;">
        <h2 style="font-weight:700;">📋 Riwayat Reservasi</h2>
        <p style="opacity:0.85;">Daftar reservasi meja Anda</p>
    </div>

    <div class="page-content">
        <div class="container">

            <?php if ($success): ?>
                <div class="alert alert-success alert-warung alert-auto-hide mb-4">✅ <?= $success ?></div>
            <?php endif; ?>

            <?php if ($reservasi_list && $reservasi_list->num_rows > 0): ?>
                <div class="table-warung">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Orang</th>
                                <th>Paket</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($r = $reservasi_list->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d M Y', strtotime($r['tanggal'])) ?></td>
                                    <td><?= date('H:i', strtotime($r['jam'])) ?> WIB</td>
                                    <td><?= $r['jumlah_orang'] ?> orang</td>
                                    <td>
                                        <?php if (!empty($r['paket']) && $r['paket'] !== 'Tanpa Paket'): ?>
                                            <span class="status-diterima"><?= htmlspecialchars($r['paket']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted small">Tanpa Paket</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $r['catatan'] ? htmlspecialchars($r['catatan']) : '<span class="text-muted">-</span>' ?></td>
                                    <td><?= badgeStatus($r['status']) ?></td>
                                    <td><small class="text-muted"><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></small></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="content-card text-center py-5">
                    <div style="font-size:4rem;">📋</div>
                    <h5 class="mt-3 fw-bold" style="color:var(--hijau-tua);">Belum Ada Reservasi</h5>
                    <p class="text-muted">Anda belum pernah membuat reservasi.</p>
                    <a href="reservasi.php" class="btn-warung mt-2">Buat Reservasi Sekarang</a>
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