<?php
session_start();

if (isset($_SESSION['id_user'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Sistem Informasi Perpustakaan</h1>
    <h3>SMK Sangkuriang 1 Cimahi</h3>

    <p>Selamat Datang di Sistem Informasi Perpustakaan</p>

    <a href="login.php">
        <button>Login</button>
    </a>

</body>
</html>
