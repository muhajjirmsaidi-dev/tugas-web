<?php
session_start();
include "../koneksi.php";
if (!isset($_SESSION['login'])) { header("Location: ../login.php"); exit; }

$id=(int)($_GET['id']??0);

mysqli_begin_transaction($koneksi);

try {
    $stmt=mysqli_prepare($koneksi,"SELECT buku_id,status FROM peminjaman WHERE id=? FOR UPDATE");
    mysqli_stmt_bind_param($stmt,"i",$id);
    mysqli_stmt_execute($stmt);
    $pinjam=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if(!$pinjam){
        throw new Exception("Data peminjaman tidak ditemukan.");
    }

    if($pinjam['status'] !== 'Dipinjam'){
        throw new Exception("Buku sudah dikembalikan.");
    }

    $stmt=mysqli_prepare($koneksi,"UPDATE peminjaman SET status='Dikembalikan' WHERE id=?");
    mysqli_stmt_bind_param($stmt,"i",$id);
    mysqli_stmt_execute($stmt);

    $stmt=mysqli_prepare($koneksi,"UPDATE buku SET stok=stok+1 WHERE id=?");
    mysqli_stmt_bind_param($stmt,"i",$pinjam['buku_id']);
    mysqli_stmt_execute($stmt);

    mysqli_commit($koneksi);
    header("Location: index.php?pesan=Buku berhasil dikembalikan");
} catch(Exception $e) {
    mysqli_rollback($koneksi);
    header("Location: index.php?pesan=".urlencode($e->getMessage()));
}
exit;
?>
