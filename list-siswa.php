<?php
include 'config.php';

// Query untuk mengambil data siswa
$sql = "SELECT * FROM calon_siswa";
$result = mysqli_query($conn, $sql);

//total data siswa
$total = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Siswa - SMAN 2 Cileungsi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 mx-auto max-w-2xl">
                <i class="fas fa-list-alt text-4xl text-blue-600 mb-3"></i>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                    Daftar Siswa Terdaftar
                </h1>
                <div class="bg-blue-600 text-white px-4 py-2 rounded-lg inline-block font-semibold">
                    SMAN 2 Cileungsi
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="max-w-6xl mx-auto mb-6">
            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                <a href="index.php"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Beranda
                </a>
                <a href="form-daftar.php"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Tambah Siswa Baru
                </a>
            </div>
        </div>

        <!-- Table Container -->
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Table Header -->
                <div class="bg-blue-600 text-white p-4">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        Data Siswa Terdaftar
                    </h3>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    No
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Foto
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Nama Lengkap
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Alamat
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Jenis Kelamin
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Agama
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Sekolah Asal
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            if ($total > 0) {
                                $number = 1;
                                while ($data = mysqli_fetch_assoc($result)) {
                            ?>
                                    <!-- Data Rows -->
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <?php echo $number++; ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <?php if (!empty($data['foto']) && file_exists('uploads/' . $data['foto'])): ?>
                                                <img src="uploads/<?php echo htmlspecialchars($data['foto']); ?>"
                                                    alt="Foto <?php echo htmlspecialchars($data['nama']); ?>"
                                                    class="h-12 w-12 rounded-full object-cover border-2 border-blue-200">
                                            <?php else: ?>
                                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-400"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <?php echo htmlspecialchars($data['nama']); ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <?php echo htmlspecialchars($data['alamat']); ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <?php echo htmlspecialchars($data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'); ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <?php echo htmlspecialchars($data['agama']); ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <?php echo htmlspecialchars($data['sekolah_asal']); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-3">
                                                <a href="show.php?id=<?php echo $data['id']; ?>"
                                                    class="text-green-600 hover:text-green-800" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="form-edit.php?id=<?php echo $data['id']; ?>"
                                                    class="text-blue-600 hover:text-blue-800" title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="hapus.php?id=<?php echo $data['id']; ?>"
                                                    class="text-red-600 hover:text-red-800"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?');"
                                                    title="Hapus Data">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <!-- Empty State -->
                                <tr id="empty-state">
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-600 mb-2">Belum Ada Data Siswa</h3>
                                            <p class="text-gray-500 mb-4">Silakan tambah siswa baru untuk melihat data di sini.</p>
                                            <a href="form-daftar.php"
                                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-plus mr-2"></i>
                                                Tambah Siswa Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Menampilkan <span class="font-medium"><?php echo $total; ?></span> dari <span class="font-medium"><?php echo $total; ?></span> siswa
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Data diperbarui otomatis
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>