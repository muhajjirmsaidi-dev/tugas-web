<?php
session_start();
include "../koneksi.php";
if (!isset($_SESSION['login'])) { header("Location: ../login.php"); exit; }

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: index.php"); exit;
}

$anggota_id=(int)$_POST['anggota_id'];
$buku_id=(int)$_POST['buku_id'];
$tanggal_pinjam=$_POST['tanggal_pinjam'];
$tanggal_kembali=$_POST['tanggal_kembali'];

if(strtotime($tanggal_kembali) < strtotime($tanggal_pinjam)){
    header("Location: index.php?pesan=Tanggal kembali tidak boleh sebelum tanggal pinjam&tipe=error"); exit;
}

mysqli_begin_transaction($koneksi);

try {
    $stmt=mysqli_prepare($koneksi,"SELECT stok FROM buku WHERE id=? FOR UPDATE");
    mysqli_stmt_bind_param($stmt,"i",$buku_id);
    mysqli_stmt_execute($stmt);
    $buku=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if(!$buku || $buku['stok'] <= 0){
        throw new Exception("Stok buku tidak tersedia.");
    }

    $stmt=mysqli_prepare($koneksi,"INSERT INTO peminjaman (anggota_id,buku_id,tanggal_pinjam,tanggal_kembali,status) VALUES (?,?,?,?, 'Dipinjam')");
    mysqli_stmt_bind_param($stmt,"iiss",$anggota_id,$buku_id,$tanggal_pinjam,$tanggal_kembali);
    mysqli_stmt_execute($stmt);

    $stmt=mysqli_prepare($koneksi,"UPDATE buku SET stok=stok-1 WHERE id=?");
    mysqli_stmt_bind_param($stmt,"i",$buku_id);
    mysqli_stmt_execute($stmt);

    mysqli_commit($koneksi);
    header("Location: index.php?pesan=Peminjaman berhasil disimpan");
} catch(Exception $e) {
    mysqli_rollback($koneksi);
    header("Location: index.php?pesan=".urlencode($e->getMessage())."&tipe=error");
}
exit;
?>
