<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare($koneksi, "DELETE FROM buku WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php?pesan=Buku berhasil dihapus");
} else {
    header("Location: index.php?pesan=Buku tidak dapat dihapus karena sudah digunakan dalam peminjaman");
}
exit;
?>
