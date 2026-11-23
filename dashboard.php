<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

// Menghitung jumlah data
$user = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_user");
$buku = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_buku");
$pinjam = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_pinjam");

$total_user = mysqli_fetch_assoc($user)['total'];
$total_buku = mysqli_fetch_assoc($buku)['total'];
$total_pinjam = mysqli_fetch_assoc($pinjam)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Dashboard Perpustakaan</h1>

    <h3>Selamat Datang, <?= htmlspecialchars($nama); ?></h3>
    <p>Role: <?= htmlspecialchars($role); ?></p>

    <hr>

    <h3>Menu Utama</h3>

    <?php if ($role == 'admin') { ?>
        <a href="user.php">Kelola Pengguna</a><br><br>
    <?php } ?>

    <a href="buku.php">Data Buku</a><br><br>

    <a href="peminjaman.php">Data Peminjaman</a><br><br>

    <hr>

    <h3>Statistik Perpustakaan</h3>

    <p>Total Pengguna: <?= $total_user; ?></p>
    <p>Total Buku: <?= $total_buku; ?></p>
    <p>Total Peminjaman: <?= $total_pinjam; ?></p>

    <br>

    <a href="logout.php"
       onclick="return confirm('Yakin ingin keluar?')">
       Logout
    </a>

</body>
</html>
