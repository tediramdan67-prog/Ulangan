<?php
session_start();
include 'koneksi.php';

// Memastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Proses tambah buku
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $query = mysqli_prepare($conn,
        "INSERT INTO tb_buku
        (judul, penerbit, tahun_terbit, stok, deskripsi)
        VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $query, "ssiis",
        $judul, $penerbit, $tahun, $stok, $deskripsi
    );

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Buku berhasil ditambahkan!');
            window.location='buku.php';
        </script>";
        exit;
    } else {
        echo "Gagal menambahkan buku!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Tambah Data Buku</h2>

    <form method="POST">

        <label>Judul Buku</label><br>
        <input type="text" name="judul" required>
        <br><br>

        <label>Penerbit</label><br>
        <input type="text" name="penerbit" required>
        <br><br>

        <label>Tahun Terbit</label><br>
        <input type="number" name="tahun_terbit" required>
        <br><br>

        <label>Stok</label><br>
        <input type="number" name="stok" min="0" required>
        <br><br>

        <label>Deskripsi</label><br>
        <textarea name="deskripsi" required></textarea>
        <br><br>

        <button type="submit" name="simpan">
            Simpan Buku
        </button>

        <a href="buku.php">Kembali</a>

    </form>

</body>
</html>
