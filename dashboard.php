<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

function jumlahData($koneksi, $tabel) {
    $result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM $tabel");
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

$totalBuku = jumlahData($koneksi, "buku");
$totalAnggota = jumlahData($koneksi, "anggota");
$totalPeminjaman = jumlahData($koneksi, "peminjaman");

$result = mysqli_query($koneksi, "SELECT COALESCE(SUM(stok),0) AS total FROM buku");
$dataStok = mysqli_fetch_assoc($result);
$totalStok = $dataStok['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Perpustakaan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand">📚 Perpustakaan</div>
        <nav>
            <a class="active" href="dashboard.php">Dashboard</a>
            <a href="buku/index.php">Data Buku</a>
            <a href="anggota/index.php">Data Anggota</a>
            <a href="peminjaman/index.php">Peminjaman</a>
            <a href="pengembalian/index.php">Pengembalian</a>
            <a href="logout.php" class="logout-link">Logout</a>
        </nav>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h2>Dashboard</h2>
                <p>Selamat datang, <?= htmlspecialchars($_SESSION['nama']) ?>.</p>
            </div>
        </header>

        <section class="cards">
            <div class="card stat-card">
                <span>Total Buku</span>
                <strong><?= $totalBuku ?></strong>
            </div>
            <div class="card stat-card">
                <span>Total Stok</span>
                <strong><?= $totalStok ?></strong>
            </div>
            <div class="card stat-card">
                <span>Total Anggota</span>
                <strong><?= $totalAnggota ?></strong>
            </div>
            <div class="card stat-card">
                <span>Peminjaman</span>
                <strong><?= $totalPeminjaman ?></strong>
            </div>
        </section>

        <div class="card">
            <h3>Menu Cepat</h3>
            <div class="quick-menu">
                <a href="buku/tambah.php" class="btn primary">+ Tambah Buku</a>
                <a href="anggota/tambah.php" class="btn primary">+ Tambah Anggota</a>
                <a href="peminjaman/tambah.php" class="btn primary">+ Peminjaman</a>
            </div>
        </div>
    </main>
</div>
</body>
</html>
