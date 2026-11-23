<?php
session_start();
include 'koneksi.php';

// Memastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Mengambil data peminjaman beserta nama dan judul buku
$query = mysqli_query($conn, "
    SELECT 
        tb_pinjam.*,
        tb_user.nama,
        tb_buku.judul
    FROM tb_pinjam
    JOIN tb_user ON tb_pinjam.id_user = tb_user.id_user
    JOIN tb_buku ON tb_pinjam.id_buku = tb_buku.id_buku
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Peminjaman</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Data Peminjaman Buku</h2>

    <a href="dashboard.php">Kembali ke Dashboard</a>
    <br><br>

    <a href="tambah_peminjaman.php">+ Tambah Peminjaman</a>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>No</th>
            <th>ID Pinjam</th>
            <th>Nama Pengguna</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Jumlah Pinjam</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['id_pinjam']; ?></td>
            <td><?= htmlspecialchars($data['nama']); ?></td>
            <td><?= htmlspecialchars($data['judul']); ?></td>
            <td><?= $data['tgl_pinjam']; ?></td>
            <td><?= $data['tgl_kembali']; ?></td>
            <td><?= $data['jml_pinjam']; ?></td>

            <td>
                <a href="edit_peminjaman.php?id=<?= $data['id_pinjam']; ?>">
                    Edit
                </a>

                |

                <a href="hapus_peminjaman.php?id=<?= $data['id_pinjam']; ?>"
                   onclick="return confirm('Yakin ingin menghapus peminjaman ini?')">
                    Hapus
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</body>
</html>
