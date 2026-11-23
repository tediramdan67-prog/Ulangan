<?php
session_start();
include 'koneksi.php';

// Memastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Mengambil ID buku
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Menghapus data buku
    $query = mysqli_prepare($conn,
        "DELETE FROM tb_buku WHERE id_buku = ?"
    );

    mysqli_stmt_bind_param($query, "i", $id);

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Data buku berhasil dihapus!');
            window.location='buku.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Gagal menghapus buku! Buku mungkin masih memiliki data peminjaman.');
            window.location='buku.php';
        </script>";
        exit;
    }

} else {
    header("Location: buku.php");
    exit;
}
?>
