<?php
include 'config.php';

// Cek apakah form telah disubmit
if (isset($_POST['update'])) {
    // Ambil data dari form
    $id = $_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $agama = mysqli_real_escape_string($conn, $_POST['agama']);
    $sekolah_asal = mysqli_real_escape_string($conn, $_POST['sekolah_asal']);
    $foto_lama = $_POST['foto_lama'];

    // Variabel untuk foto baru
    $foto = $foto_lama; // Default menggunakan foto lama

    // Cek apakah ada permintaan untuk menghapus foto
    if (isset($_POST['hapus_foto']) && $_POST['hapus_foto'] == 'on') {
        // Hapus file foto lama jika ada
        if (!empty($foto_lama) && file_exists('uploads/' . $foto_lama)) {
            unlink('uploads/' . $foto_lama);
        }
        $foto = NULL; // Set foto menjadi NULL di database
    }
    // Cek apakah ada upload foto baru
    elseif (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
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
                // Buat nama file yang unik
                $foto_baru = uniqid() . '.' . $file_ext;

                // Buat direktori uploads jika belum ada
                if (!file_exists('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                // Path tujuan file
                $upload_path = 'uploads/' . $foto_baru;

                // Pindahkan file dari temporary folder ke tujuan
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Hapus file foto lama jika ada
                    if (!empty($foto_lama) && file_exists('uploads/' . $foto_lama)) {
                        unlink('uploads/' . $foto_lama);
                    }
                    $foto = $foto_baru;
                } else {
                    // Gagal upload file
                    header('Location: form-edit.php?id=' . $id . '&status=gagal-upload');
                    exit();
                }
            } else {
                // Ukuran file terlalu besar
                header('Location: form-edit.php?id=' . $id . '&status=file-terlalu-besar');
                exit();
            }
        } else {
            // Ekstensi file tidak diizinkan
            header('Location: form-edit.php?id=' . $id . '&status=ekstensi-tidak-diizinkan');
            exit();
        }
    }

    // Query untuk update data
    $sql = "UPDATE calon_siswa SET 
            nama='$nama', 
            alamat='$alamat', 
            jenis_kelamin='$jenis_kelamin', 
            agama='$agama', 
            sekolah_asal='$sekolah_asal'";

    // Tambahkan foto ke query jika ada perubahan
    if ($foto !== $foto_lama) {
        $sql .= ", foto=" . ($foto ? "'$foto'" : "NULL");
    }

    $sql .= " WHERE id=$id";

    // Jalankan query
    $result = mysqli_query($conn, $sql);

    // Cek hasil query
    if ($result) {
        // Jika berhasil, redirect ke halaman list dengan status sukses
        header('Location: list-siswa.php?status=sukses-edit');
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
        echo "<br><a href='form-edit.php?id=$id'>Kembali ke form edit</a>";
    }
} else {
    // Jika tidak melalui form submit, redirect ke halaman list
    header('Location: list-siswa.php');
}
