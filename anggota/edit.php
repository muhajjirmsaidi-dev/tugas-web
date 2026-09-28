<?php
session_start();
include "../koneksi.php";
if (!isset($_SESSION['login'])) { header("Location: ../login.php"); exit; }

$id=(int)($_GET['id']??0);
$stmt=mysqli_prepare($koneksi,"SELECT * FROM anggota WHERE id=?");
mysqli_stmt_bind_param($stmt,"i",$id); mysqli_stmt_execute($stmt);
$anggota=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if(!$anggota){header("Location: index.php");exit;}

$error="";
if(isset($_POST['simpan'])){
    $nim=trim($_POST['nim']); $nama=trim($_POST['nama']); $alamat=trim($_POST['alamat']); $no_hp=trim($_POST['no_hp']);
    $stmt=mysqli_prepare($koneksi,"UPDATE anggota SET nim=?, nama=?, alamat=?, no_hp=? WHERE id=?");
    mysqli_stmt_bind_param($stmt,"ssssi",$nim,$nama,$alamat,$no_hp,$id);
    if(mysqli_stmt_execute($stmt)){header("Location: index.php?pesan=Anggota berhasil diperbarui");exit;}
    $error="Gagal memperbarui anggota.";
}
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Edit Anggota</title><link rel="stylesheet" href="../css/style.css"></head>
<body><div class="layout"><aside class="sidebar"><div class="brand">📚 Perpustakaan</div><nav><a href="../dashboard.php">Dashboard</a><a href="../buku/index.php">Data Buku</a><a class="active" href="index.php">Data Anggota</a><a href="../peminjaman/index.php">Peminjaman</a><a href="../pengembalian/index.php">Pengembalian</a><a href="../logout.php" class="logout-link">Logout</a></nav></aside>
<main class="main"><header class="topbar"><div><h2>Edit Anggota</h2><p>Perbarui data anggota.</p></div></header><div class="card form-card"><?php if($error): ?><div class="alert error"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post"><label>NIM</label><input type="text" name="nim" value="<?=htmlspecialchars($anggota['nim'])?>" required><label>Nama</label><input type="text" name="nama" value="<?=htmlspecialchars($anggota['nama'])?>" required><label>Alamat</label><textarea name="alamat" rows="4" required><?=htmlspecialchars($anggota['alamat'])?></textarea><label>No. HP</label><input type="text" name="no_hp" value="<?=htmlspecialchars($anggota['no_hp'])?>" required><div class="form-actions"><a href="index.php" class="btn secondary">Kembali</a><button name="simpan" class="btn primary">Simpan Perubahan</button></div></form>
</div></main></div></body></html>
