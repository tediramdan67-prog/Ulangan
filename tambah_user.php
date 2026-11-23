<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $kelas = $_POST['kelas'];

    $query = mysqli_prepare($conn,
        "INSERT INTO tb_user (nama, email, pass, role, kelas)
         VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $query, "sssss",
        $nama, $email, $password, $role, $kelas
    );

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Pengguna berhasil ditambahkan!');
            window.location='user.php';
        </script>";
    } else {
        echo "Gagal menambahkan pengguna: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengguna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Tambah Pengguna</h2>

    <form method="POST">

        <label>Nama</label><br>
        <input type="text" name="nama" required>
        <br><br>

        <label>Email</label><br>
        <input type="email" name="email" required>
        <br><br>

        <label>Password</label><br>
        <input type="password" name="password" required>
        <br><br>

        <label>Role</label><br>
        <select name="role" required>
            <option value="">Pilih Role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        <br><br>

        <label>Kelas</label><br>
        <input type="text" name="kelas" required>
        <br><br>

        <button type="submit" name="simpan">Simpan</button>
        <a href="user.php">Kembali</a>

    </form>

</body>
</html>
