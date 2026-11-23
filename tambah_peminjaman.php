
<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $id_user = $_POST['id_user'];
    $id_buku = $_POST['id_buku'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $jml_pinjam = $_POST['jml_pinjam'];

    $query = mysqli_prepare($conn,
        "INSERT INTO tb_pinjam
        (id_user, id_buku, tgl_pinjam, tgl_kembali, jml_pinjam)
        VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $query, "iissi",
        $id_user, $id_buku,
        $tgl_pinjam, $tgl_kembali, $jml_pinjam
    );

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Peminjaman berhasil ditambahkan!');
            window.location='peminjaman.php';
        </script>";
        exit;
    } else {
        echo "Gagal menambahkan peminjaman!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Peminjaman</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Tambah Peminjaman Buku</h2>

    <form method="POST">

        <label>Nama Pengguna</label><br>
        <select name="id_user" required>
            <option value="">Pilih Pengguna</option>

            <?php
            $user = mysqli_query($conn, "SELECT * FROM tb_user");

            while ($u = mysqli_fetch_assoc($user)) {
            ?>
                <option value="<?= $u['id_user']; ?>">
                    <?= htmlspecialchars($u['nama']); ?>
                </option>
            <?php } ?>

        </select>
        <br><br>

        <label>Judul Buku</label><br>
        <select name="id_buku" required>
            <option value="">Pilih Buku</option>

            <?php
            $buku = mysqli_query($conn, "SELECT * FROM tb_buku");

            while ($b = mysqli_fetch_assoc($buku)) {
            ?>
                <option value="<?= $b['id_buku']; ?>">
                    <?= htmlspecialchars($b['judul']); ?>
                </option>
            <?php } ?>

        </select>
        <br><br>

        <label>Tanggal Pinjam</label><br>
        <input type="date" name="tgl_pinjam" required>
        <br><br>

        <label>Tanggal Kembali</label><br>
        <input type="date" name="tgl_kembali" required>
        <br><br>

        <label>Jumlah Pinjam</label><br>
        <input type="number" name="jml_pinjam" min="1" required>
        <br><br>

        <button type="submit" name="simpan">
            Simpan Peminjaman
        </button>

        <a href="peminjaman.php">Kembali</a>

    </form>

</body>
</html>
