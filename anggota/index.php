<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$keyword = $_GET['keyword'] ?? "";
$stmt = mysqli_prepare($koneksi, "SELECT * FROM anggota WHERE nama LIKE ? OR nim LIKE ? OR no_hp LIKE ? ORDER BY id DESC");
$like = "%$keyword%";
mysqli_stmt_bind_param($stmt, "sss", $like, $like, $like);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Data Anggota</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="layout">
<aside class="sidebar"><div class="brand">📚 Perpustakaan</div><nav>
<a href="../dashboard.php">Dashboard</a><a href="../buku/index.php">Data Buku</a><a class="active" href="index.php">Data Anggota</a><a href="../peminjaman/index.php">Peminjaman</a><a href="../pengembalian/index.php">Pengembalian</a><a href="../logout.php" class="logout-link">Logout</a>
</nav></aside>
<main class="main">
<header class="topbar"><div><h2>Data Anggota</h2><p>Kelola data anggota perpustakaan.</p></div><a href="tambah.php" class="btn primary">+ Tambah Anggota</a></header>
<?php if (isset($_GET['pesan'])): ?><div class="alert success"><?= htmlspecialchars($_GET['pesan']) ?></div><?php endif; ?>
<div class="card">
<form class="search-form" method="get"><input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari nama, NIM, atau nomor HP..."><button class="btn primary">Cari</button><?php if($keyword): ?><a href="index.php" class="btn secondary">Reset</a><?php endif; ?></form>
<div class="table-wrap"><table>
<thead><tr><th>No</th><th>NIM</th><th>Nama</th><th>Alamat</th><th>No. HP</th><th>Aksi</th></tr></thead>
<tbody>
<?php $no=1; while($row=mysqli_fetch_assoc($data)): ?>
<tr><td><?= $no++ ?></td><td><?= htmlspecialchars($row['nim']) ?></td><td><?= htmlspecialchars($row['nama']) ?></td><td><?= htmlspecialchars($row['alamat']) ?></td><td><?= htmlspecialchars($row['no_hp']) ?></td><td class="actions"><a href="edit.php?id=<?= $row['id'] ?>" class="btn small">Edit</a><a href="hapus.php?id=<?= $row['id'] ?>" class="btn small danger" onclick="return confirm('Yakin ingin menghapus anggota ini?')">Hapus</a></td></tr>
<?php endwhile; ?>
<?php if(mysqli_num_rows($data)==0): ?><tr><td colspan="6" class="empty">Data anggota tidak ditemukan.</td></tr><?php endif; ?>
</tbody></table></div>
</div>
</main>
</div>
</body>
</html>
