CREATE DATABASE IF NOT EXISTS perpustakaan;
USE perpustakaan;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE anggota (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(30) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_buku VARCHAR(30) NOT NULL UNIQUE,
    judul VARCHAR(150) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun_terbit YEAR NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anggota_id INT NOT NULL,
    buku_id INT NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE NOT NULL,
    status ENUM('Dipinjam','Dikembalikan') NOT NULL DEFAULT 'Dipinjam',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_peminjaman_anggota
        FOREIGN KEY (anggota_id) REFERENCES anggota(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,

    CONSTRAINT fk_peminjaman_buku
        FOREIGN KEY (buku_id) REFERENCES buku(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

INSERT INTO users (username, password, nama)
VALUES ('muhajir', 'muhajir123', 'ajir');

INSERT INTO buku (kode_buku, judul, penulis, penerbit, tahun_terbit, kategori, stok) VALUES
('BK001', 'Dasar Pemrograman', 'Abdul Kadir', 'Andi', 2023, 'Pemrograman', 5),
('BK002', 'Basis Data', 'Rosa A.S.', 'Informatika', 2022, 'Database', 4),
('BK003', 'Algoritma dan Struktur Data', 'Budi Raharjo', 'Modula', 2024, 'Algoritma', 3);

INSERT INTO anggota (nim, nama, alamat, no_hp) VALUES
('2026001', 'Andi', 'Ternate', '081234567890'),
('2026002', 'Budi', 'Jambula', '082345678901'),
('2026003', 'Citra', 'Ternate Selatan', '083456789012');
