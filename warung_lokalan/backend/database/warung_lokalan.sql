-- ============================================================
-- Database: warung_lokalan
-- Warung Lokalan - Sistem Reservasi Warung Makan Sederhana
-- ============================================================

CREATE DATABASE IF NOT EXISTS warung_lokalan
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE warung_lokalan;

-- ============================================================
-- Tabel: users
-- Menyimpan data pelanggan dan admin
-- ============================================================
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nama        VARCHAR(100)        NOT NULL,
    email       VARCHAR(150)        NOT NULL UNIQUE,
    password    VARCHAR(255)        NOT NULL,
    telepon     VARCHAR(20)         DEFAULT NULL,
    alamat      TEXT                DEFAULT NULL,
    role        ENUM('admin','pelanggan') NOT NULL DEFAULT 'pelanggan',
    created_at  TIMESTAMP           DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- Tabel: menu
-- Menyimpan daftar makanan dan minuman
-- ============================================================
CREATE TABLE IF NOT EXISTS menu (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nama        VARCHAR(150)        NOT NULL,
    kategori    ENUM('makanan','minuman') NOT NULL DEFAULT 'makanan',
    harga       DECIMAL(10,2)       NOT NULL,
    deskripsi   TEXT                DEFAULT NULL,
    gambar      VARCHAR(255)        DEFAULT NULL,
    tersedia    TINYINT(1)          NOT NULL DEFAULT 1,
    created_at  TIMESTAMP           DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- Tabel: reservasi
-- Menyimpan data pemesanan meja pelanggan
-- ============================================================
CREATE TABLE IF NOT EXISTS reservasi (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT             NOT NULL,
    tanggal         DATE            NOT NULL,
    jam             TIME            NOT NULL,
    jumlah_orang    INT             NOT NULL,
    -- Paket makan & minum yang dipilih (NULL = tanpa paket)
    paket           VARCHAR(50)     DEFAULT NULL,
    catatan         TEXT            DEFAULT NULL,
    status          ENUM('menunggu','diterima','ditolak') NOT NULL DEFAULT 'menunggu',
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- Data Awal: Akun Admin
-- Password: admin123
-- ============================================================
INSERT INTO users (nama, email, password, telepon, alamat, role) VALUES
(
    'Admin Warung',
    'admin@warunglokalan.com',
    '$2y$10$J5SQkjPUB.PFTYKMOcgk9uBs.HRrOIkv/FPMvB4j9DpE6qf8IcrK.',
    '081234567890',
    'Jl. Warung Lokalan No. 1, Kota',
    'admin'
);

-- ============================================================
-- Data Awal: Contoh Menu Makanan
-- ============================================================
INSERT INTO menu (nama, kategori, harga, deskripsi, tersedia) VALUES
('Nasi Goreng Spesial',   'makanan', 18000, 'Nasi goreng dengan telur, ayam, dan sayuran segar.',          1),
('Mie Ayam Bakso',        'makanan', 15000, 'Mie ayam kuah dengan bakso sapi pilihan.',                    1),
('Ayam Bakar Madu',       'makanan', 22000, 'Ayam bakar dengan bumbu madu dan rempah khas.',               1),
('Soto Ayam Kampung',     'makanan', 14000, 'Soto kuah bening dengan ayam kampung asli.',                  1),
('Gado-Gado Jakarta',     'makanan', 13000, 'Sayuran rebus dengan bumbu kacang gurih.',                    1),
('Tempe Orek Pedas',      'makanan', 8000,  'Tempe goreng kering dimasak dengan cabai dan kecap.',         1),
('Es Teh Manis',          'minuman', 5000,  'Teh hitam manis segar dengan es batu.',                      1),
('Es Jeruk',              'minuman', 7000,  'Jeruk segar diperas, manis dan menyegarkan.',                 1),
('Jus Alpukat',           'minuman', 12000, 'Jus alpukat lembut dengan susu dan gula.',                   1),
('Air Mineral',           'minuman', 4000,  'Air mineral dingin kemasan.',                                 1),
('Kopi Hitam',            'minuman', 6000,  'Kopi hitam robusta tanpa gula, khas warung.',                 1),
('Es Cendol',             'minuman', 8000,  'Cendol dengan santan, gula merah, dan es serut.',             1);
