<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM tb_buku");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Data Buku Perpustakaan</h2>

    <a href="dashboard.php">Kembali ke Dashboard</a>
    <br><br>

    <a href="tambah_buku.php">+ Tambah Buku</a>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>No</th>
            <th>ID Buku</th>
            <th>Judul</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th>Stok</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['id_buku']; ?></td>
            <td><?= htmlspecialchars($data['judul']); ?></td>
            <td><?= htmlspecialchars($data['penerbit']); ?></td>
            <td><?= $data['tahun_terbit']; ?></td>
            <td><?= $data['stok']; ?></td>
            <td><?= htmlspecialchars($data['deskripsi']); ?></td>

            <td>
                <a href="edit_buku.php?id=<?= $data['id_buku']; ?>">
                    Edit
                </a>

                |

                <a href="hapus_buku.php?id=<?= $data['id_buku']; ?>"
                   onclick="return confirm('Yakin ingin menghapus buku ini?')">
                    Hapus
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</body>
</html>
