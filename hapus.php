<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Query untuk menghapus data siswa berdasarkan id
    $sql = "DELETE FROM calon_siswa WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    // Cek apakah query berhasil
    if ($result) {
        // Jika berhasil, redirect ke halaman list dengan status sukses
        header('Location: list-siswa.php?status=sukses-hapus');
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
        echo "<br><a href='list-siswa.php'>Kembali ke daftar siswa</a>";
    }
} else {
    // Jika tidak ada id, redirect ke halaman list
    die("ID tidak ditemukan.");
}
