<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($koneksi, "SELECT * FROM buku WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$buku = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$buku) {
    header("Location: index.php");
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

    $stmt = mysqli_prepare($koneksi, "UPDATE buku SET kode_buku=?, judul=?, penulis=?, penerbit=?, tahun_terbit=?, kategori=?, stok=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssissi", $kode, $judul, $penulis, $penerbit, $tahun, $kategori, $stok, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?pesan=Buku berhasil diperbarui");
        exit;
    }
    $error = "Gagal memperbarui buku.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Edit Buku</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="layout">
<aside class="sidebar"><div class="brand">📚 Perpustakaan</div><nav>
<a href="../dashboard.php">Dashboard</a><a class="active" href="index.php">Data Buku</a><a href="../anggota/index.php">Data Anggota</a><a href="../peminjaman/index.php">Peminjaman</a><a href="../pengembalian/index.php">Pengembalian</a><a href="../logout.php" class="logout-link">Logout</a>
</nav></aside>
<main class="main">
<header class="topbar"><div><h2>Edit Buku</h2><p>Perbarui data buku.</p></div></header>
<div class="card form-card">
<?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
<label>Kode Buku</label><input type="text" name="kode_buku" value="<?= htmlspecialchars($buku['kode_buku']) ?>" required>
<label>Judul Buku</label><input type="text" name="judul" value="<?= htmlspecialchars($buku['judul']) ?>" required>
<label>Penulis</label><input type="text" name="penulis" value="<?= htmlspecialchars($buku['penulis']) ?>" required>
<label>Penerbit</label><input type="text" name="penerbit" value="<?= htmlspecialchars($buku['penerbit']) ?>" required>
<label>Tahun Terbit</label><input type="number" name="tahun_terbit" value="<?= $buku['tahun_terbit'] ?>" required>
<label>Kategori</label><input type="text" name="kategori" value="<?= htmlspecialchars($buku['kategori']) ?>" required>
<label>Stok</label><input type="number" name="stok" min="0" value="<?= $buku['stok'] ?>" required>
<div class="form-actions"><a href="index.php" class="btn secondary">Kembali</a><button type="submit" name="simpan" class="btn primary">Simpan Perubahan</button></div>
</form>
</div>
</main>
</div>
</body>
</html>
