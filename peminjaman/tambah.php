<?php
session_start();
include "../koneksi.php";
if (!isset($_SESSION['login'])) { header("Location: ../login.php"); exit; }

$anggota=mysqli_query($koneksi,"SELECT id,nim,nama FROM anggota ORDER BY nama ASC");
$buku=mysqli_query($koneksi,"SELECT id,kode_buku,judul,stok FROM buku WHERE stok > 0 ORDER BY judul ASC");
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Peminjaman Baru</title><link rel="stylesheet" href="../css/style.css"></head>
<body><div class="layout"><aside class="sidebar"><div class="brand">📚 Perpustakaan</div><nav><a href="../dashboard.php">Dashboard</a><a href="../buku/index.php">Data Buku</a><a href="../anggota/index.php">Data Anggota</a><a class="active" href="index.php">Peminjaman</a><a href="../pengembalian/index.php">Pengembalian</a><a href="../logout.php" class="logout-link">Logout</a></nav></aside>
<main class="main"><header class="topbar"><div><h2>Peminjaman Baru</h2><p>Buat transaksi peminjaman buku.</p></div></header>
<div class="card form-card"><form method="post" action="proses.php">
<label>Anggota</label><select name="anggota_id" required><option value="">-- Pilih Anggota --</option><?php while($a=mysqli_fetch_assoc($anggota)): ?><option value="<?=$a['id']?>"><?=htmlspecialchars($a['nim']." - ".$a['nama'])?></option><?php endwhile;?></select>
<label>Buku</label><select name="buku_id" required><option value="">-- Pilih Buku --</option><?php while($b=mysqli_fetch_assoc($buku)): ?><option value="<?=$b['id']?>"><?=htmlspecialchars($b['kode_buku']." - ".$b['judul']." (Stok: ".$b['stok'].")")?></option><?php endwhile;?></select>
<label>Tanggal Pinjam</label><input type="date" name="tanggal_pinjam" value="<?=date('Y-m-d')?>" required>
<label>Tanggal Kembali</label><input type="date" name="tanggal_kembali" value="<?=date('Y-m-d',strtotime('+7 days'))?>" required>
<div class="form-actions"><a href="index.php" class="btn secondary">Kembali</a><button type="submit" class="btn primary">Simpan Peminjaman</button></div>
</form></div></main></div></body></html>
