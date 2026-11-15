<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pelanggan') {
    header('Location: login.php?error=Silakan+login+terlebih+dahulu');
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
    <title>Reservasi</title>
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
                    <li class="nav-item"><a class="nav-link active" href="reservasi.php">Reservasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
                    <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
                    <li class="nav-item ms-2"><a class="nav-link btn-logout" href="../backend/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="background:var(--hijau-tua);padding:40px 0 30px;color:white;text-align:center;">
        <h2 style="font-weight:700;">📅 Buat Reservasi</h2>
        <p style="opacity:0.85;">Pesan meja Anda sekarang</p>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="content-card">
                        <h5 class="fw-bold mb-4" style="color:var(--hijau-tua);">Formulir Reservasi</h5>

                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-warung alert-auto-hide">⚠️ <?= $error ?></div>
                        <?php endif; ?>
                        <?php if ($success): ?>
                            <div class="alert alert-success alert-warung alert-auto-hide">✅ <?= $success ?></div>
                        <?php endif; ?>

                        <form action="../backend/proses_reservasi.php" method="POST" class="form-warung">
                            <div class="mb-3">
                                <label class="form-label">Nama Pemesan</label>
                                <input type="text" class="form-control"
                                    value="<?= htmlspecialchars($_SESSION['nama']) ?>" disabled>
                                <small class="text-muted">Nama sesuai akun Anda</small>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Reservasi <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label for="jam" class="form-label">Jam Kedatangan <span class="text-danger">*</span></label>
                                <select class="form-control" id="jam" name="jam" required>
                                    <option value="">-- Pilih Jam --</option>
                                    <option value="10:00">10.00</option>
                                    <option value="11:00">11.00</option>
                                    <option value="12:00">12.00</option>
                                    <option value="13:00">13.00</option>
                                    <option value="17:00">17.00</option>
                                    <option value="18:00">18.00</option>
                                    <option value="19:00">19.00</option>
                                    <option value="20:00">20.00</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah_orang" class="form-label">Jumlah Orang <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="jumlah_orang" name="jumlah_orang"
                                    min="1" max="20" placeholder="Contoh: 4" required>
                                <small class="text-muted">Maksimal 20 orang</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih Paket <span class="text-muted small">(opsional)</span></label>
                                <div class="d-flex flex-column gap-2" id="paket-list">
                                    <label class="paket-option selected">
                                        <input type="radio" name="paket" value="Tanpa Paket" checked>
                                        <div class="paket-info">
                                            <span class="paket-nama">Tanpa Paket</span>
                                            <span class="paket-desc text-muted">Pesan langsung di tempat</span>
                                        </div>
                                        <span class="paket-harga">—</span>
                                    </label>
                                    <label class="paket-option">
                                        <input type="radio" name="paket" value="Paket Hemat" data-harga="20000">
                                        <div class="paket-info">
                                            <span class="paket-nama">Paket Hemat</span>
                                            <span class="paket-desc text-muted">Nasi Goreng + Es Teh Manis</span>
                                        </div>
                                        <span class="paket-harga">Rp 20.000/orang</span>
                                    </label>
                                    <label class="paket-option">
                                        <input type="radio" name="paket" value="Paket Spesial" data-harga="28000">
                                        <div class="paket-info">
                                            <span class="paket-nama">Paket Spesial</span>
                                            <span class="paket-desc text-muted">Ayam Bakar Madu + Jus Alpukat</span>
                                        </div>
                                        <span class="paket-harga">Rp 28.000/orang</span>
                                    </label>
                                    <label class="paket-option">
                                        <input type="radio" name="paket" value="Paket Keluarga" data-harga="18000">
                                        <div class="paket-info">
                                            <span class="paket-nama">Paket Keluarga</span>
                                            <span class="paket-desc text-muted">Soto Ayam Kampung + Es Teh Manis</span>
                                        </div>
                                        <span class="paket-harga">Rp 18.000/orang</span>
                                    </label>
                                </div>

                                <div id="estimasi-total" class="mt-2 p-2 rounded" style="background:var(--hijau-cerah);display:none;">
                                    💰 Estimasi: <strong id="estimasi-nilai"></strong>
                                    <small class="text-muted d-block">Pembayaran dilakukan di tempat</small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="catatan" class="form-label">Catatan Tambahan</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                    placeholder="Contoh: Mohon meja di dekat jendela, ada yang berulang tahun, dll."></textarea>
                            </div>
                            <button type="submit" class="btn-warung w-100 py-2">
                                📅 Buat Reservasi
                            </button>
                        </form>

                    </div>

                    <div class="content-card mt-4">
                        <h6 class="fw-bold mb-3" style="color:var(--hijau-tua);">ℹ️ Informasi Warung</h6>
                        <div class="row g-2 text-muted small">
                            <div class="col-6">🕙 Jam Buka</div>
                            <div class="col-6">: 10.00 - 21.00 WIB</div>
                            <div class="col-6">📅 Hari Buka</div>
                            <div class="col-6">: Senin - Jum'at</div>
                            <div class="col-6">👥 Kapasitas Meja</div>
                            <div class="col-6">: Maks. 20 orang</div>
                            <div class="col-6">📋 Konfirmasi</div>
                            <div class="col-6">: Oleh Admin</div>
                        </div>
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