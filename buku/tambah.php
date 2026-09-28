<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$error = "";

if (isset($_POST['simpan'])) {
    $kode = trim($_POST['kode_buku']);
    $judul = trim($_POST['judul']);
    $penulis = trim($_POST['penulis']);
    $penerbit = trim($_POST['penerbit']);
    $tahun = (int)$_POST['tahun_terbit'];
    $kategori = trim($_POST['kategori']);
    $stok = (int)$_POST['stok'];

    $stmt = mysqli_prepare($koneksi, "INSERT INTO buku (kode_buku, judul, penulis, penerbit, tahun_terbit, kategori, stok) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssisi", $kode, $judul, $penulis, $penerbit, $tahun, $kategori, $stok);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?pesan=Buku berhasil ditambahkan");
        exit;
    } else {
        $error = "Gagal menambahkan buku. Pastikan kode buku belum digunakan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Tambah Buku</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="layout">
<aside class="sidebar"><div class="brand">📚 Perpustakaan</div><nav>
<a href="../dashboard.php">Dashboard</a><a class="active" href="index.php">Data Buku</a><a href="../anggota/index.php">Data Anggota</a><a href="../peminjaman/index.php">Peminjaman</a><a href="../pengembalian/index.php">Pengembalian</a><a href="../logout.php" class="logout-link">Logout</a>
</nav></aside>
<main class="main">
<header class="topbar"><div><h2>Tambah Buku</h2><p>Masukkan data buku baru.</p></div></header>
<div class="card form-card">
<?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
<label>Kode Buku</label><input type="text" name="kode_buku" required>
<label>Judul Buku</label><input type="text" name="judul" required>
<label>Penulis</label><input type="text" name="penulis" required>
<label>Penerbit</label><input type="text" name="penerbit" required>
<label>Tahun Terbit</label><input type="number" name="tahun_terbit" min="1900" max="2100" required>
<label>Kategori</label><input type="text" name="kategori" required>
<label>Stok</label><input type="number" name="stok" min="0" required>
<div class="form-actions"><a href="index.php" class="btn secondary">Kembali</a><button type="submit" name="simpan" class="btn primary">Simpan</button></div>
</form>
</div>
</main>
</div>
</body>
</html>
