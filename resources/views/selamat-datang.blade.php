<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Aplikasi OPD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar dengan Tombol Login/Register -->
    <nav class="bg-blue-900 shadow-md py-4 px-6 flex justify-between items-center">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold text-gray-800 m-0"></h2>
        </div>
        <div class="flex items-center space-x-0">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-4 py-2 rounded-l bg-blue-800 text-white hover:bg-blue-700 transition border-r border-blue-900">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 rounded-l bg-blue-800 text-white hover:bg-blue-700 transition border-r border-blue-900">
                        Login
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 bg-blue-800 text-white hover:bg-blue-700 transition rounded-r">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-blue-900 text-white text-center pt-0 pb-8 px-4">
        <h1 class="text-5xl font-bold mb-4">Manajemen Rekap Aplikasi</h1>
        <p class="text-xl max-w-2xl mx-auto">Sistem pengelolaan aplikasi pemerintahan secara efisien dan terstruktur</p>
    </header>

    <!-- Tentang Aplikasi -->
    <section class="max-w-4xl mx-auto py-12 px-6">
        <h2 class="text-2xl font-semibold text-center mb-8">Tentang Aplikasi</h2>
        <div class="bg-white p-8 rounded-lg shadow-md">
            <p class="text-gray-700">
                Aplikasi ini dirancang untuk mempermudah proses pengajuan, assessment, pengembangan,
                dan pengelolaan akses server terhadap aplikasi yang digunakan oleh Organisasi Perangkat Daerah (OPD).
                Dengan sistem ini, semua tahapan manajemen aplikasi menjadi terdokumentasi dan transparan.
            </p>
        </div>
    </section>

    <!-- Alur Kerja -->
    <section class="max-w-4xl mx-auto py-12 px-8">
        <h2 class="text-2xl font-semibold text-center mb-8">Fitur Utama</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h3 class="text-xl font-medium mb-4 text-blue-700">🔹OPD</h3>
                <ul class="space-y-2 list-disc list-inside text-gray-700">
                    <li>Mengisi form pengajuan assessment</li>
                    <li>Menunggu proses assessment</li>
                    <li>Memantau pengembangan aplikasi</li>
                </ul>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h3 class="text-xl font-medium mb-4 text-orange-700">🔸Admin</h3>
                <ul class="space-y-2 list-disc list-inside text-gray-700">
                    <li>Melihat daftar pengajuan dari OPD</li>
                    <li>Mengelola assessment aplikasi</li>
                    <li>Memantau pengembangan aplikasi</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-gray-200 py-16 px-4 text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-semibold mb-6">Mulai Kelola Aplikasi OPD Sekarang</h2>
            <p class="mb-8 text-gray-700">Silakan login atau daftar untuk mengakses sistem manajemen aplikasi</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-8 px-4 text-center">
        <p>&copy; 2025 Manajemen Aplikasi OPD. Hak Cipta Dilindungi.</p>
    </footer>
</body>
</html>
