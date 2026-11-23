<?php
session_start();
include 'koneksi.php';

$error = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = mysqli_prepare(
        $koneksi,
        "SELECT * FROM tb_user WHERE email = ?"
    );

    mysqli_stmt_bind_param($sql, "s", $email);
    mysqli_stmt_execute($sql);

    $hasil = mysqli_stmt_get_result($sql);
    $data = mysqli_fetch_assoc($hasil);

    if ($data && password_verify($password, $data['pass'])) {

        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['role'] = $data['role'];

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Email atau password salah!";
    }

    mysqli_stmt_close($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="container">
    <div class="card">

        <h2>Login Perpustakaan</h2>

        <?php if ($error != "") { ?>
            <p style="color:red;">
                <?php echo $error; ?>
            </p>
        <?php } ?>

        <form method="POST">

            <label>Email</label>
            <input type="email" name="email"
                   placeholder="Masukkan email"
                   required>

            <label>Password</label>
            <input type="password" name="password"
                   placeholder="Masukkan password"
                   required>

            <button type="submit" name="login">
                Login
            </button>

        </form>

        <p style="margin-top:20px;">
            Belum punya akun?
            <a href="register.php">Daftar sekarang</a>
        </p>

        <a href="index.php">Kembali</a>

    </div>
</div>

</body>
</html>
