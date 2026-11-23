<?php
session_start();
include 'koneksi.php';

// Memastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Mengambil ID peminjaman
if (!isset($_GET['id'])) {
    header("Location: peminjaman.php");
    exit;
}

$id = $_GET['id'];

// Mengambil data peminjaman
$query = mysqli_prepare($conn,
    "SELECT * FROM tb_pinjam WHERE id_pinjam = ?"
);

mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data peminjaman tidak ditemukan!");
}

// Proses update
if (isset($_POST['update'])) {
    $id_user = $_POST['id_user'];
    $id_buku = $_POST['id_buku'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $jml_pinjam = $_POST['jml_pinjam'];

    $query = mysqli_prepare($conn,
        "UPDATE tb_pinjam
         SET id_user = ?, id_buku = ?,
         tgl_pinjam = ?, tgl_kembali = ?,
         jml_pinjam = ?
         WHERE id_pinjam = ?"
    );

    mysqli_stmt_bind_param(
        $query, "iissii",
        $id_user, $id_buku,
        $tgl_pinjam, $tgl_kembali,
        $jml_pinjam, $id
    );

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Data peminjaman berhasil diubah!');
            window.location='peminjaman.php';
        </script>";
        exit;
    } else {
        echo "Gagal mengubah data peminjaman!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Peminjaman</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Edit Data Peminjaman</h2>

    <form method="POST">

        <label>Nama Pengguna</label><br>
        <select name="id_user" required>
            <?php
            $user = mysqli_query($conn, "SELECT * FROM tb_user");

            while ($u = mysqli_fetch_assoc($user)) {
            ?>
                <option value="<?= $u['id_user']; ?>"
                    <?= $data['id_user'] == $u['id_user'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($u['nama']); ?>
                </option>
            <?php } ?>
        </select>
        <br><br>

        <label>Judul Buku</label><br>
        <select name="id_buku" required>
            <?php
            $buku = mysqli_query($conn, "SELECT * FROM tb_buku");

            while ($b = mysqli_fetch_assoc($buku)) {
            ?>
                <option value="<?= $b['id_buku']; ?>"
                    <?= $data['id_buku'] == $b['id_buku'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($b['judul']); ?>
                </option>
            <?php } ?>
        </select>
        <br><br>

        <label>Tanggal Pinjam</label><br>
        <input type="date" name="tgl_pinjam"
        value="<?= $data['tgl_pinjam']; ?>" required>
        <br><br>

        <label>Tanggal Kembali</label><br>
        <input type="date" name="tgl_kembali"
        value="<?= $data['tgl_kembali']; ?>" required>
        <br><br>

        <label>Jumlah Pinjam</label><br>
        <input type="number" name="jml_pinjam" min="1"
        value="<?= $data['jml_pinjam']; ?>" required>
        <br><br>

        <button type="submit" name="update">
            Update Peminjaman
        </button>

        <a href="peminjaman.php">Kembali</a>

    </form>

</body>
</html>
