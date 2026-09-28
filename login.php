<?php
session_start();
include "koneksi.php";

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT id, username, password, nama FROM users WHERE username = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {

        // Cek password biasa
        if ($password == $user['password']) {

            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Password salah.";
        }

    } else {
        $error = "Username tidak ditemukan.";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Perpustakaan</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body class="login-page">

    <div class="login-box">

        <h1>Perpustakaan</h1>

        <p class="login-subtitle">
            Sistem Informasi Perpustakaan
        </p>

        <?php if ($error): ?>

            <div class="alert error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>

        <form method="post">

            <label>Username</label>

            <input
                type="text"
                name="username"
                placeholder="Masukkan username"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

            <button
                type="submit"
                name="login"
                class="btn primary full"
            >
                Login
            </button>

        </form>

      

    </div>

</body>

</html>