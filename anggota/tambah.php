<?php
session_start();
include "../koneksi.php";
if (!isset($_SESSION['login'])) { header("Location: ../login.php"); exit; }

$error="";
if(isset($_POST['simpan'])){
    $nim=trim($_POST['nim']);
    $nama=trim($_POST['nama']);
    $alamat=trim($_POST['alamat']);
    $no_hp=trim($_POST['no_hp']);

    $stmt=mysqli_prepare($koneksi,"INSERT INTO anggota (nim,nama,alamat,no_hp) VALUES (?,?,?,?)");
    mysqli_stmt_bind_param($stmt,"ssss",$nim,$nama,$alamat,$no_hp);

    if(mysqli_stmt_execute($stmt)){
        header("Location: index.php?pesan=Anggota berhasil ditambahkan"); exit;
    }
    $error="Gagal menambahkan anggota. Pastikan NIM belum digunakan.";
}
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Tambah Anggota</title><link rel="stylesheet" href="../css/style.css"></head>
<body><div class="layout">
<aside class="sidebar"><div class="brand">📚 Perpustakaan</div><nav><a href="../dashboard.php">Dashboard</a><a href="../buku/index.php">Data Buku</a><a class="active" href="index.php">Data Anggota</a><a href="../peminjaman/index.php">Peminjaman</a><a href="../pengembalian/index.php">Pengembalian</a><a href="../logout.php" class="logout-link">Logout</a></nav></aside>
<main class="main"><header class="topbar"><div><h2>Tambah Anggota</h2><p>Masukkan data anggota baru.</p></div></header>
<div class="card form-card"><?php if($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post"><label>NIM</label><input type="text" name="nim" required><label>Nama</label><input type="text" name="nama" required><label>Alamat</label><textarea name="alamat" rows="4" required></textarea><label>No. HP</label><input type="text" name="no_hp" required><div class="form-actions"><a href="index.php" class="btn secondary">Kembali</a><button name="simpan" class="btn primary">Simpan</button></div></form>
</div></main></div></body></html>
