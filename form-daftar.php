
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran - SMAN 2 Cileungsi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 mx-auto max-w-2xl">
                <i class="fas fa-user-plus text-4xl text-green-600 mb-3"></i>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                    Form Pendaftaran Siswa Baru
                </h1>
                <div class="bg-blue-600 text-white px-4 py-2 rounded-lg inline-block font-semibold">
                    SMAN 2 Cileungsi
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <form action="proses-pendaftaran.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                    
                    <!-- Foto -->
                    <div>
                        <label for="foto" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-image text-blue-600 mr-2"></i>
                            Foto Siswa
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-gray-400 text-2xl"></i>
                            </div>
                            <div class="flex flex-col">
                                <div class="relative">
                                    <input type="file" 
                                        id="foto" 
                                        name="foto" 
                                        accept=".jpg,.jpeg,.png"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 inline-block text-center">
                                        <i class="fas fa-upload mr-2"></i>
                                        Pilih Foto
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG. Maks: 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user text-blue-600 mr-2"></i>
                            Nama Lengkap
                        </label>
                        <input type="text"
                            id="nama"
                            name="nama"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="Masukkan nama lengkap siswa">
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>
                            Alamat Lengkap
                        </label>
                        <textarea id="alamat"
                            name="alamat"
                            required
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="Masukkan alamat lengkap"></textarea>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-venus-mars text-blue-600 mr-2"></i>
                            Jenis Kelamin
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio"
                                    name="jenis_kelamin"
                                    value="L"
                                    required
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-gray-700">Laki-laki</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio"
                                    name="jenis_kelamin"
                                    value="P"
                                    required
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-gray-700">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <!-- Agama -->
                    <div>
                        <label for="agama" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-pray text-blue-600 mr-2"></i>
                            Agama
                        </label>
                        <select id="agama"
                            name="agama"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>

                    <!-- Sekolah Asal -->
                    <div>
                        <label for="sekolah_asal" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-school text-blue-600 mr-2"></i>
                            Sekolah Asal
                        </label>
                        <input type="text"
                            id="sekolah_asal"
                            name="sekolah_asal"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="Masukkan nama sekolah asal (SMP/MTs)">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit" name="daftar"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Daftar Sekarang
                        </button>
                        <a href="index.php"
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Section -->
        <div class="max-w-2xl mx-auto mt-8">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Petunjuk:</strong> Pastikan semua data yang dimasukkan sudah benar.
                            Data yang telah disimpan dapat diedit melalui menu List Daftar Siswa.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>