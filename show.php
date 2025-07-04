
<?php
include 'config.php';

// Cek apakah parameter id ada
if (!isset($_GET['id'])) {
    header('Location: list-siswa.php');
    exit();
}

$id = $_GET['id'];

// Query untuk mengambil data siswa berdasarkan id
$sql = "SELECT * FROM calon_siswa WHERE id = $id";
$result = mysqli_query($conn, $sql);

// Cek apakah data ditemukan
if (mysqli_num_rows($result) == 0) {
    header('Location: list-siswa.php');
    exit();
}

// Ambil data siswa
$siswa = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa - SMAN 2 Cileungsi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 mx-auto max-w-2xl">
                <i class="fas fa-user-circle text-4xl text-blue-600 mb-3"></i>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                    Detail Siswa
                </h1>
                <div class="bg-blue-600 text-white px-4 py-2 rounded-lg inline-block font-semibold">
                    SMAN 2 Cileungsi
                </div>
            </div>
        </div>

        <!-- Card Profile -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="md:flex">
                    <!-- Foto Profile Section -->
                    <div class="md:w-1/3 bg-gradient-to-br from-blue-500 to-indigo-600 p-8 text-center">
                        <div class="w-40 h-40 mx-auto rounded-full bg-white p-2 shadow-lg mb-4">
                            <?php if (!empty($siswa['foto']) && file_exists('uploads/' . $siswa['foto'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($siswa['foto']); ?>" 
                                     alt="Foto <?php echo htmlspecialchars($siswa['nama']); ?>" 
                                     class="w-full h-full rounded-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400 text-6xl"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-2"><?php echo htmlspecialchars($siswa['nama']); ?></h2>
                        <p class="text-blue-100 mb-4">
                            <i class="fas fa-id-card mr-2"></i>
                            ID: <?php echo $siswa['id']; ?>
                        </p>
                        <div class="inline-block bg-white/20 rounded-lg px-4 py-2 text-white">
                            <i class="fas <?php echo $siswa['jenis_kelamin'] == 'L' ? 'fa-male' : 'fa-female'; ?> mr-2"></i>
                            <?php echo $siswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                        </div>
                    </div>

                    <!-- Data Detail Section -->
                    <div class="md:w-2/3 p-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-200">
                            Informasi Pribadi
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Nama Lengkap -->
                            <div class="flex">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Nama Lengkap</h4>
                                    <p class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($siswa['nama']); ?></p>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="flex">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Alamat</h4>
                                    <p class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($siswa['alamat']); ?></p>
                                </div>
                            </div>

                            <!-- Agama -->
                            <div class="flex">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-pray text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Agama</h4>
                                    <p class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($siswa['agama']); ?></p>
                                </div>
                            </div>

                            <!-- Sekolah Asal -->
                            <div class="flex">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-school text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Sekolah Asal</h4>
                                    <p class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($siswa['sekolah_asal']); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 mt-8 pt-4 border-t border-gray-200">
                            <a href="list-siswa.php" class="flex-1 flex items-center justify-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                            <a href="form-edit.php?id=<?php echo $siswa['id']; ?>" class="flex-1 flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meta Info -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-blue-50 rounded-xl border border-blue-100 p-4">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3 text-xl"></i>
                    <div>
                        <p class="text-sm text-blue-800">
                            Data ini merupakan informasi resmi siswa yang terdaftar di SMAN 2 Cileungsi. 
                            Jika ada kesalahan data, silakan hubungi administrasi sekolah atau gunakan tombol edit.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>