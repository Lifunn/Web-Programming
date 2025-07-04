<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa - SMAN 2 Cileungsi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="bg-white rounded-xl shadow-lg p-8 mx-auto max-w-2xl">
                <div class="mb-6">
                    <i class="fas fa-graduation-cap text-6xl text-blue-600 mb-4"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                    Pendaftaran Siswa Baru
                </h1>
                <div class="bg-blue-600 text-white px-6 py-3 rounded-lg inline-block font-semibold text-xl">
                    SMAN 2 Cileungsi
                </div>
            </div>
        </div>

        <!-- Menu Buttons -->
        <div class="flex flex-col md:flex-row gap-6 justify-center items-center max-w-4xl mx-auto">
            <!-- Daftar Baru Button -->
            <div class="w-full md:w-80">
                <a href="form-daftar.php" class="group block">
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 p-8 text-center border-2 border-transparent hover:border-green-500">
                        <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                            <i class="fas fa-user-plus text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Daftar Baru</h3>
                        <p class="text-gray-600">Daftarkan siswa baru untuk tahun ajaran mendatang</p>
                        <div class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg font-semibold group-hover:bg-green-700 transition-colors">
                            Mulai Pendaftaran
                        </div>
                    </div>
                </a>
            </div>

            <!-- List Daftar Siswa Button -->
            <div class="w-full md:w-80">
                <a href="list-siswa.php" class="group block">
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 p-8 text-center border-2 border-transparent hover:border-blue-500">
                        <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors">
                            <i class="fas fa-list-alt text-2xl text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">List Daftar Siswa</h3>
                        <p class="text-gray-600">Lihat daftar siswa yang telah mendaftar</p>
                        <div class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold group-hover:bg-blue-700 transition-colors">
                            Lihat Daftar
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-center mt-12">
            <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
                <p class="text-gray-600 mb-2">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Sistem Pendaftaran Siswa Baru Online
                </p>
                <p class="text-sm text-gray-500">
                    Untuk informasi lebih lanjut, hubungi bagian administrasi sekolah
                </p>
            </div>
        </div>
    </div>
</body>

</html>