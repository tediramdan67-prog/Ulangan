<?php
session_start();
include 'koneksi.php';

// Memastikan hanya admin yang bisa menghapus
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Mengambil ID pengguna
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mencegah admin menghapus akunnya sendiri
    if ($id == $_SESSION['id_user']) {
        echo "<script>
            alert('Anda tidak bisa menghapus akun sendiri!');
            window.location='user.php';
        </script>";
        exit;
    }

    // Menghapus data pengguna
    $query = mysqli_prepare($conn,
        "DELETE FROM tb_user WHERE id_user = ?"
    );

    mysqli_stmt_bind_param($query, "i", $id);

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Data pengguna berhasil dihapus!');
            window.location='user.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus pengguna!');
            window.location='user.php';
        </script>";
    }
} else {
    header("Location: user.php");
    exit;
}
?>
