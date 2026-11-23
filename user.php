<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM tb_user");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pengguna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Data Pengguna Perpustakaan</h2>

    <a href="dashboard.php">Kembali ke Dashboard</a>
    <br><br>

    <a href="tambah_user.php">+ Tambah Pengguna</a>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>ID User</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Kelas</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['id_user']; ?></td>
            <td><?= htmlspecialchars($data['nama']); ?></td>
            <td><?= htmlspecialchars($data['email']); ?></td>
            <td><?= htmlspecialchars($data['kelas']); ?></td>
            <td><?= htmlspecialchars($data['role']); ?></td>

            <td>
                <a href="edit_user.php?id=<?= $data['id_user']; ?>">
                    Edit
                </a>

                |

                <a href="hapus_user.php?id=<?= $data['id_user']; ?>"
                   onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                    Hapus
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</body>
</html>
