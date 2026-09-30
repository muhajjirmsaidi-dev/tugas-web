```php
<?php
session_start();

include "../koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

// Mengambil data peminjaman
$sql = "
    SELECT 
        p.id,
        a.nim,
        a.nama,
        b.kode_buku,
        b.judul,
        p.tanggal_pinjam,
        p.tanggal_kembali,
        p.status
    FROM peminjaman p
    JOIN anggota a ON p.anggota_id = a.id
    JOIN buku b ON p.buku_id = b.id
    ORDER BY p.id DESC
";

$data = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengembalian</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="layout">

    <!-- Sidebar -->
    <aside class="sidebar">

        <div class="brand">
            📚 Perpustakaan
        </div>

        <nav>

            <a href="../dashboard.php">
                Dashboard
            </a>

            <a href="../buku/index.php">
                Data Buku
            </a>

            <a href="../anggota/index.php">
                Data Anggota
            </a>

            <a href="../peminjaman/index.php">
                Peminjaman
            </a>

            <a href="index.php" class="active">
                Pengembalian
            </a>

            <a href="../logout.php" class="logout-link">
                Logout
            </a>

        </nav>

    </aside>


    <!-- Konten Utama -->
    <main class="main">

        <!-- Header -->
        <header class="topbar">

            <div>
                <h2>Pengembalian</h2>
                <p>Kelola pengembalian buku.</p>
            </div>

        </header>


        <!-- Pesan Berhasil -->
        <?php if (isset($_GET['pesan'])): ?>

            <div class="alert success">
                <?= htmlspecialchars($_GET['pesan']) ?>
            </div>

        <?php endif; ?>


        <!-- Tabel Pengembalian -->
        <div class="card">

            <div class="table-wrap">

                <table>

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $no = 1;

                    if (mysqli_num_rows($data) > 0):

                        while ($row = mysqli_fetch_assoc($data)):
                    ?>

                        <tr>

                            <!-- Nomor -->
                            <td>
                                <?= $no++ ?>
                            </td>


                            <!-- Anggota -->
                            <td>
                                <?= htmlspecialchars(
                                    $row['nim'] . " - " . $row['nama']
                                ) ?>
                            </td>


                            <!-- Buku -->
                            <td>
                                <?= htmlspecialchars($row['judul']) ?>
                            </td>


                            <!-- Tanggal Pinjam -->
                            <td>
                                <?= htmlspecialchars($row['tanggal_pinjam']) ?>
                            </td>


                            <!-- Jatuh Tempo -->
                            <td>
                                <?= htmlspecialchars($row['tanggal_kembali']) ?>
                            </td>


                            <!-- Status -->
                            <td>

                                <?php if ($row['status'] == 'Dipinjam'): ?>

                                    <span class="badge warning">
                                        <?= htmlspecialchars($row['status']) ?>
                                    </span>

                                <?php else: ?>

                                    <span class="badge success">
                                        <?= htmlspecialchars($row['status']) ?>
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- Aksi -->
                            <td>

                                <?php if ($row['status'] == 'Dipinjam'): ?>

                                    <a
                                        class="btn small primary"
                                        href="proses.php?id=<?= $row['id'] ?>"
                                        onclick="return confirm('Konfirmasi pengembalian buku ini?')"
                                    >
                                        Kembalikan
                                    </a>

                                <?php else: ?>

                                    <span>
                                        - sudah kembali -
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php
                        endwhile;

                    else:
                    ?>

                        <tr>
                            <td colspan="7" class="empty">
                                Belum ada transaksi.
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>
```
