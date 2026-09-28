<?php
session_start();
include "../koneksi.php";
if (!isset($_SESSION['login'])) { header("Location: ../login.php"); exit; }

$sql="SELECT p.id,a.nim,a.nama,b.kode_buku,b.judul,p.tanggal_pinjam,p.tanggal_kembali,p.status
      FROM peminjaman p JOIN anggota a ON p.anggota_id=a.id JOIN buku b ON p.buku_id=b.id
      ORDER BY p.id DESC";
$data=mysqli_query($koneksi,$sql);
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Pengembalian</title><link rel="stylesheet" href="../css/style.css"></head>
<body><div class="layout"><aside class="sidebar"><div class="brand">📚 Perpustakaan</div><nav><a href="../dashboard.php">Dashboard</a><a href="../buku/index.php">Data Buku</a><a href="../anggota/index.php">Data Anggota</a><a href="../peminjaman/index.php">Peminjaman</a><a class="active" href="index.php">Pengembalian</a><a href="../logout.php" class="logout-link">Logout</a></nav></aside>
<main class="main"><header class="topbar"><div><h2>Pengembalian</h2><p>Kelola pengembalian buku.</p></div></header>
<?php if(isset($_GET['pesan'])): ?><div class="alert success"><?=htmlspecialchars($_GET['pesan'])?></div><?php endif;?>
<div class="card"><div class="table-wrap"><table><thead><tr><th>No</th><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
<?php $no=1; while($row=mysqli_fetch_assoc($data)): ?><tr><td><?=$no++?></td><td><?=htmlspecialchars($row['nim']." - ".$row['nama'])?></td><td><?=htmlspecialchars($row['judul'])?></td><td><?=$row['tanggal_pinjam']?></td><td><?=$row['tanggal_kembali']?></td><td><span class="badge <?=$row['status']=='Dipinjam'?'warning':'success'?>"><?=$row['status']?></span></td><td><?php if($row['status']=='Dipinjam'): ?><a class="btn small primary" href="proses.php?id=<?=$row['id']?>" onclick="return confirm('Konfirmasi pengembalian buku ini?')">Kembalikan</a><?php else: ?>- sudah kembali -<?php endif;?></td></tr><?php endwhile;?>
<?php if(mysqli_num_rows($data)==0): ?><tr><td colspan="7" class="empty">Belum ada transaksi.</td></tr><?php endif;?>
</tbody></table></div></div></main></div></body></html>
