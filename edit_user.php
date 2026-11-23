<?php
session_start();
include 'koneksi.php';

// Memastikan hanya admin yang bisa mengedit
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Mengambil ID pengguna
if (!isset($_GET['id'])) {
    header("Location: user.php");
    exit;
}

$id = $_GET['id'];

// Mengambil data pengguna
$query = mysqli_prepare($conn,
    "SELECT * FROM tb_user WHERE id_user = ?"
);

mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data pengguna tidak ditemukan!");
}

// Proses update data
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $kelas = $_POST['kelas'];

    $query = mysqli_prepare($conn,
        "UPDATE tb_user
         SET nama = ?, email = ?, role = ?, kelas = ?
         WHERE id_user = ?"
    );

    mysqli_stmt_bind_param(
        $query, "ssssi",
        $nama, $email, $role, $kelas, $id
    );

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Data pengguna berhasil diubah!');
            window.location='user.php';
        </script>";
        exit;
    } else {
        echo "Gagal mengubah data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengguna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Edit Data Pengguna</h2>

    <form method="POST">

        <label>Nama</label><br>
        <input type="text" name="nama"
        value="<?= htmlspecialchars($data['nama']); ?>" required>
        <br><br>

        <label>Email</label><br>
        <input type="email" name="email"
        value="<?= htmlspecialchars($data['email']); ?>" required>
        <br><br>

        <label>Role</label><br>
        <select name="role" required>
            <option value="admin"
                <?= $data['role'] == 'admin' ? 'selected' : ''; ?>>
                Admin
            </option>

            <option value="user"
                <?= $data['role'] == 'user' ? 'selected' : ''; ?>>
                User
            </option>
        </select>
        <br><br>

        <label>Kelas</label><br>
        <input type="text" name="kelas"
        value="<?= htmlspecialchars($data['kelas']); ?>" required>
        <br><br>

        <button type="submit" name="update">Update</button>
        <a href="user.php">Kembali</a>

    </form>

</body>
</html>
