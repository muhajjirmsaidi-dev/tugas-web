<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$keyword = $_GET['keyword'] ?? "";

$stmt = mysqli_prepare($koneksi, "SELECT * FROM buku WHERE kode_buku LIKE ? OR judul LIKE ? OR penulis LIKE ? OR penerbit LIKE ? ORDER BY id DESC");
$like = "%$keyword%";
mysqli_stmt_bind_param($stmt, "ssss", $like, $like, $like, $like);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Buku</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="layout">
<aside class="sidebar">
<div class="brand">📚 Perpustakaan</div>
<nav>
<a href="../dashboard.php">Dashboard</a>
<a class="active" href="index.php">Data Buku</a>
<a href="../anggota/index.php">Data Anggota</a>
<a href="../peminjaman/index.php">Peminjaman</a>
<a href="../pengembalian/index.php">Pengembalian</a>
<a href="../logout.php" class="logout-link">Logout</a>
</nav>
</aside>

<main class="main">
<header class="topbar">
<div><h2>Data Buku</h2><p>Kelola data buku perpustakaan.</p></div>
<a href="tambah.php" class="btn primary">+ Tambah Buku</a>
</header>

<?php if (isset($_GET['pesan'])): ?>
<div class="alert success"><?= htmlspecialchars($_GET['pesan']) ?></div>
<?php endif; ?>

<div class="card">
<form class="search-form" method="get">
<input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari kode, judul, penulis, atau penerbit...">
<button class="btn primary">Cari</button>
<?php if ($keyword): ?><a href="index.php" class="btn secondary">Reset</a><?php endif; ?>
</form>

<div class="table-wrap">
<table>
<thead>
<tr>
<th>No</th><th>Kode</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Kategori</th><th>Stok</th><th>Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; while ($row=mysqli_fetch_assoc($data)): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= htmlspecialchars($row['kode_buku']) ?></td>
<td><?= htmlspecialchars($row['judul']) ?></td>
<td><?= htmlspecialchars($row['penulis']) ?></td>
<td><?= htmlspecialchars($row['penerbit']) ?></td>
<td><?= htmlspecialchars($row['tahun_terbit']) ?></td>
<td><?= htmlspecialchars($row['kategori']) ?></td>
<td><?= $row['stok'] ?></td>
<td class="actions">
<a href="edit.php?id=<?= $row['id'] ?>" class="btn small">Edit</a>
<a href="hapus.php?id=<?= $row['id'] ?>" class="btn small danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
</td>
</tr>
<?php endwhile; ?>
<?php if (mysqli_num_rows($data) == 0): ?>
<tr><td colspan="9" class="empty">Data buku tidak ditemukan.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</main>
</div>
</body>
</html>
