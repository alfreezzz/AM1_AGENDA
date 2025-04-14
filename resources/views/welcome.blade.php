<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AM Agenda Pembelajaran Harian</title>
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}">
    @vite('resources/css/app.css')

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes scaleIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .animate-scale-in {
            animation: scaleIn 0.6s ease-out forwards;
        }
        
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .bg-gradient-overlay {
            background: linear-gradient(135deg, rgba(23, 37, 84, 0.9), rgba(55, 65, 81, 0.85));
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 font-sans antialiased min-h-screen flex flex-col">
    <!-- Hero Section with Navigation -->
    <header class="relative bg-gradient-to-r from-indigo-900 to-gray-900 min-h-screen flex flex-col">
        <div class="absolute inset-0 bg-pattern opacity-10" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgdmlld0JveD0iMCAwIDYwIDYwIj48cGF0aCBkPSJNMTIgMGgxOHYxOEgxMlYwem0xOCAwaDEydjEySDMwVjB6bTAgMTJoMTJ2NkgzMHYtNnptMCA2aDEydjEySDMwVjE4ek0xMiAxOGgxOHYxMkgxMlYxOHptMCAxMmgxOHYxMkgxMlYzMHptMCAxMmgxOHYxOEgxMlY0MnptMTggMGgxMnYxOEgzMFY0MnptMTIgMGgxOHYxOEg0MlY0MnoiIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iLjUiIGZpbGwtcnVsZT0iZXZlbm9kZCIvPjwvc3ZnPg==')"></div>
        
        <div class="relative container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="shadow-lg">
                        <img src="{{ asset('assets/images/icon.png') }}" alt="SMK Amaliah" class="w-16 h-16">
                    </div>
                    <div class="max-sm:hidden">
                        <h1 class="text-xl font-bold text-white text-shadow">SMK Amaliah 1&2 Ciawi</h1>
                        <p class="text-indigo-200 italic text-sm font-light">Tauhid is Our Fundament</p>
                    </div>
                </div>
                
                <a href="{{ route('login') }}" class="ml-auto px-5 py-2 bg-white text-indigo-700 rounded-full font-medium shadow-md hover:bg-indigo-50 transition duration-300 transform hover:scale-105">Masuk</a>
            </div>
        </div>
        
        <!-- Hero Content -->
        <div class="relative container mx-auto px-4 py-16 md:py-24 my-auto">
            <div class="lg:max-w-3xl mx-auto text-center sm:max-w-2xl max-w-xl">
                <h2 class="sm:text-4xl lg:text-5xl text-2xl font-bold text-white lg:mb-6 mb-3 sm:mb-4 leading-tight animate-fade-in text-shadow">AM Agenda Pembelajaran Harian</h2>
                <p class="lg:text-xl sm:text-lg text-sm text-indigo-100 mb-8 animate-fade-in opacity-0" style="animation-delay: 0.3s">Sistem Manajemen Agenda Pembelajaran Terpadu untuk Meningkatkan Kualitas Pendidikan</p>
                
                <div class="flex flex-wrap justify-center gap-4 animate-fade-in opacity-0" style="animation-delay: 0.6s">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-semibold rounded-xl shadow-lg hover:from-indigo-500 hover:to-blue-400 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                        <div class="flex items-center max-sm:text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Masuk ke Aplikasi
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="relative h-16 md:h-24 bg-transparent mt-auto">
            <svg class="absolute bottom-0 w-full h-full text-blue-50" preserveAspectRatio="none" viewBox="0 0 1440 74" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 24C120 -8 240 -8 360 24C480 56 600 56 720 40C840 24 960 -8 1080 8C1200 24 1320 88 1440 72V74H0V24Z" />
            </svg>
        </div>
    </header>
    <section class="bg-gradient-to-bl from-indigo-50 to-blue-50 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-extrabold text-indigo-800 mb-2">Keunggulan Aplikasi</h3>
                <p class="text-gray-600 text-base">Mengapa memilih <strong>AM Agenda Pembelajaran Harian</strong>?</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Reusable Card -->
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg border-t-4 border-indigo-500 transform transition-all duration-200 hover:-translate-y-1 active:scale-105 cursor-pointer">
                    <div class="flex items-center mb-4 text-indigo-600">
                        <!-- Calendar Icon -->
                        <svg class="w-8 h-8 mr-3 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <h4 class="text-xl font-bold">Agenda Terstruktur</h4>
                    </div>
                    <p class="text-gray-600">Guru dapat mencatat dan mengelola agenda harian dengan sistematis dan mudah diakses.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-green-500 transform transition-all duration-200 hover:-translate-y-1 active:scale-105 cursor-pointer">
                    <div class="flex items-center mb-4 text-green-600">
                        <svg class="w-8 h-8 mr-3 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z" />
                        </svg>
                        <h4 class="text-xl font-bold">Akses Berdasarkan Peran</h4>
                    </div>
                    <p class="text-gray-600">Admin, guru, dan siswa memiliki tampilan dan hak akses yang berbeda sesuai tugasnya.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-blue-500 transform transition-all duration-200 hover:-translate-y-1 active:scale-105 cursor-pointer">
                    <div class="flex items-center mb-4 text-blue-600">
                        <svg class="w-8 h-8 mr-3 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h3m4 4v4m0 0v4m0-4h4m-4 0h-4" />
                        </svg>
                        <h4 class="text-xl font-bold">Monitoring Efektif</h4>
                    </div>
                    <p class="text-gray-600">Admin dapat memantau agenda dan absensi real-time untuk pengawasan optimal.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-yellow-500 transform transition-all duration-200 hover:-translate-y-1 active:scale-105 cursor-pointer">
                    <div class="flex items-center mb-4 text-yellow-600">
                        <svg class="w-8 h-8 mr-3 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L8 15.25m0 0L6.25 17m1.75-1.75v4.25m8.5-4.25L16 15.25m0 0L14.25 17m1.75-1.75v4.25M12 3v18" />
                        </svg>
                        <h4 class="text-xl font-bold">Responsif & Mobile Friendly</h4>
                    </div>
                    <p class="text-gray-600">Nyaman digunakan baik di desktop maupun smartphone tanpa kehilangan fungsionalitas.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-red-500 transform transition-all duration-200 hover:-translate-y-1 active:scale-105 cursor-pointer">
                    <div class="flex items-center mb-4 text-red-600">
                        <svg class="w-8 h-8 mr-3 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.1.9-2 2-2s2 .9 2 2a2 2 0 11-4 0zm-6 3a6 6 0 1112 0v2H6v-2z" />
                        </svg>
                        <h4 class="text-xl font-bold">Keamanan Terjamin</h4>
                    </div>
                    <p class="text-gray-600">Role-based access dan proteksi CSRF menjaga keamanan data pengguna.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-purple-500 transform transition-all duration-200 hover:-translate-y-1 active:scale-105 cursor-pointer">
                    <div class="flex items-center mb-4 text-purple-600">
                        <svg class="w-8 h-8 mr-3 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6 4a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h4 class="text-xl font-bold">Riwayat Data Tersimpan</h4>
                    </div>
                    <p class="text-gray-600">Semua catatan agenda tersimpan rapi dan dapat diakses untuk evaluasi & dokumentasi.</p>
                </div>
            </div>
        </div>
    </section>

<!-- Optional animation helper -->
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.7s ease forwards;
}
.delay-100 { animation-delay: 0.1s; }
.delay-200 { animation-delay: 0.2s; }
.delay-300 { animation-delay: 0.3s; }
.delay-400 { animation-delay: 0.4s; }
.delay-500 { animation-delay: 0.5s; }
</style>

    <footer class="bg-white border-t border-gray-200 py-4 mt-auto">
        <div class="container mx-auto px-4">
            <p class="text-center text-gray-500 sm:text-sm text-xs">&copy; {{ date('Y') }} SMK Amaliah 1&2 Ciawi. Hak Cipta Dilindungi.</p>
        </div>

    </footer>
</body>
</html>