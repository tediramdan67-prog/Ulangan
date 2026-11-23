<?php
session_start();
include 'koneksi.php';

// Memastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Mengambil ID buku
if (!isset($_GET['id'])) {
    header("Location: buku.php");
    exit;
}

$id = $_GET['id'];

// Mengambil data buku
$query = mysqli_prepare($conn,
    "SELECT * FROM tb_buku WHERE id_buku = ?"
);

mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data buku tidak ditemukan!");
}

// Proses update buku
if (isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $query = mysqli_prepare($conn,
        "UPDATE tb_buku
         SET judul = ?, penerbit = ?,
         tahun_terbit = ?, stok = ?, deskripsi = ?
         WHERE id_buku = ?"
    );

    mysqli_stmt_bind_param(
        $query, "ssiisi",
        $judul, $penerbit, $tahun,
        $stok, $deskripsi, $id
    );

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Data buku berhasil diubah!');
            window.location='buku.php';
        </script>";
        exit;
    } else {
        echo "Gagal mengubah data buku!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Edit Data Buku</h2>

    <form method="POST">

        <label>Judul Buku</label><br>
        <input type="text" name="judul"
        value="<?= htmlspecialchars($data['judul']); ?>" required>
        <br><br>

        <label>Penerbit</label><br>
        <input type="text" name="penerbit"
        value="<?= htmlspecialchars($data['penerbit']); ?>" required>
        <br><br>

        <label>Tahun Terbit</label><br>
        <input type="number" name="tahun_terbit"
        value="<?= htmlspecialchars($data['tahun_terbit']); ?>" required>
        <br><br>

        <label>Stok</label><br>
        <input type="number" name="stok" min="0"
        value="<?= htmlspecialchars($data['stok']); ?>" required>
        <br><br>

        <label>Deskripsi</label><br>
        <textarea name="deskripsi" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>
        <br><br>

        <button type="submit" name="update">Update Buku</button>
        <a href="buku.php">Kembali</a>

    </form>

</body>
</html>
