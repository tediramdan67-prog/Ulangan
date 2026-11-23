<?php
include 'koneksi.php';

$id = $_GET['id'];

// Hapus data peminjaman
$query = mysqli_query($koneksi, "DELETE FROM tb_pinjam WHERE id_peminjaman='$id'");

if ($query) {
    echo "<script>
        alert('Data peminjaman berhasil dihapus!');
        window.location='peminjaman.php';
    </script>";
} else {
    echo "<script>
        alert('Data peminjaman gagal dihapus!');
        window.location='peminjaman.php';
    </script>";
}
?>
