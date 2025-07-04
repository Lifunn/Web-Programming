<?php
include 'config.php';

// Cek apakah form telah disubmit dengan memeriksa tombol daftar
if (isset($_POST['daftar'])) {
    // Ambil data dari form
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $agama = mysqli_real_escape_string($conn, $_POST['agama']);
    $sekolah_asal = mysqli_real_escape_string($conn, $_POST['sekolah_asal']);

    // Inisialisasi variabel untuk nama file foto
    $foto_nama = NULL;

    // Proses upload foto jika ada
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        // Dapatkan informasi file
        $file_name = $_FILES['foto']['name'];
        $file_size = $_FILES['foto']['size'];
        $file_tmp = $_FILES['foto']['tmp_name'];

        // Dapatkan ekstensi file
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Ekstensi yang diizinkan
        $allowed_ext = array("jpg", "jpeg", "png");

        // Cek ekstensi file
        if (in_array($file_ext, $allowed_ext)) {
            // Cek ukuran file (max 2MB)
            if ($file_size <= 2097152) {
                // Buat nama file yang unik untuk menghindari konflik
                $foto_nama = uniqid() . '.' . $file_ext;

                // Buat direktori uploads jika belum ada
                if (!file_exists('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                // Path tujuan file
                $upload_path = 'uploads/' . $foto_nama;

                // Pindahkan file dari temporary folder ke tujuan
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // File berhasil diupload
                } else {
                    // Gagal upload file
                    header('Location: form-daftar.php?status=gagal-upload');
                    exit();
                }
            } else {
                // Ukuran file terlalu besar
                header('Location: form-daftar.php?status=file-terlalu-besar');
                exit();
            }
        } else {
            // Ekstensi file tidak diizinkan
            header('Location: form-daftar.php?status=ekstensi-tidak-diizinkan');
            exit();
        }
    }

    // Query untuk insert data
    $sql = "INSERT INTO calon_siswa (nama, alamat, jenis_kelamin, agama, sekolah_asal, foto) 
            VALUES ('$nama', '$alamat', '$jenis_kelamin', '$agama', '$sekolah_asal', " .
        ($foto_nama ? "'$foto_nama'" : "NULL") . ")";

    // Jalankan query
    if (mysqli_query($conn, $sql)) {
        // Berhasil
        header('Location: list-siswa.php?status=sukses');
    } else {
        // Gagal
        header('Location: form-daftar.php?status=gagal-simpan&error=' . mysqli_error($conn));
    }
    exit();
} else {
    // Jika diakses langsung
    header('Location: index.php');
    exit();
}
