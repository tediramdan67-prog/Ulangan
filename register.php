<?php
include 'koneksi.php';

$pesan = "";

if (isset($_POST['daftar'])) {

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $kelas = $_POST['kelas'];

    // Periksa email
    $cek = mysqli_prepare(
        $koneksi,
        "SELECT id_user FROM tb_user WHERE email = ?"
    );

    mysqli_stmt_bind_param($cek, "s", $email);
    mysqli_stmt_execute($cek);
    $hasil = mysqli_stmt_get_result($cek);

    if (mysqli_num_rows($hasil) > 0) {
        $pesan = "Email sudah terdaftar!";
    } else {

        // Enkripsi password
        $pass = password_hash($password, PASSWORD_DEFAULT);

        $role = "Anggota";

        $sql = mysqli_prepare(
            $koneksi,
            "INSERT INTO tb_user (email, pass, role, nama, kelas)
             VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $sql,
            "sssss",
            $email,
            $pass,
            $role,
            $nama,
            $kelas
        );

        if (mysqli_stmt_execute($sql)) {
    header("Location: login.php");
    exit;
} else {
    $pesan = "Pendaftaran gagal: " . mysqli_stmt_error($sql);
}
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="card">

        <h2>Registrasi Anggota</h2>

        <p style="color:red;">
            <?php echo $pesan; ?>
        </p>

        <form method="POST">

            <label>Nama</label>
            <input type="text" name="nama" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password"
                   minlength="8" required>

            <label>Kelas</label>
            <input type="text" name="kelas" required>

            <button type="submit" name="daftar">
                Daftar
            </button>

        </form>

        <p>
            Sudah punya akun?
            <a href="login.php">Login</a>
        </p>

    </div>
</div>

</body>
</html>
