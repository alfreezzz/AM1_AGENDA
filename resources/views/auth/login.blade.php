<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://unpkg.com/alpinejs" defer></script>
    @vite('resources/css/app.css')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}">
</head>
<body class="bg-gradient-to-br from-gray-900 to-black min-h-screen relative flex flex-col justify-between">
    <!-- Background with overlay -->
    <div class="absolute inset-0 w-full h-full">
        <img src="{{ asset('assets/images/am_bg.png') }}" class="absolute inset-0 w-full h-full object-cover" alt="Background">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <!-- Content Area -->
    <div class="relative z-10 flex-grow flex items-center justify-center px-4 py-12">
        <div x-data="{ showPassword: false }" class="w-full max-w-md">
            <!-- Card Container -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 pb-12 shadow-2xl border border-white/20">
                <!-- School Logo and Title -->
                <div class="flex flex-col items-center space-y-4 mb-8">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('assets/images/icon.png') }}" alt="SMK Amaliah" 
                             class="w-16 h-16 transform hover:scale-105 transition-transform duration-300">
                        <div class="text-white">
                            <h1 class="text-lg font-serif font-semibold">SMK Amaliah 1&2 Ciawi</h1>
                            <p class="text-sm italic text-gray-300">Tauhid is Our Fundament</p>
                        </div>
                    </div>
                </div>

                <!-- Login Form -->
                <form action="{{ url('login') }}" method="post" class="space-y-4">
                    @csrf
                    <!-- Username Field -->
                    <div class="space-y-2">
                        <label for="name" class="text-white text-sm font-medium block">Nama</label>
                        <input type="text" id="name" name="name" 
                               class="w-full px-3 py-1.5 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-all duration-300"
                               placeholder="Masukkan nama anda"
                               value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="text-white text-sm font-medium block">Password</label>
                        <div class="relative">
                            <input 
                                :type="showPassword ? 'text' : 'password'"
                                id="password" 
                                name="password"
                                class="w-full px-3 py-1.5 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-all duration-300"
                                placeholder="Masukkan password">
                            <button 
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                               class="w-4 h-4 rounded border-gray-300 text-green-500 focus:ring-green-500">
                        <label for="remember" class="ml-2 text-sm text-gray-300">Ingat Saya</label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" 
                            class="w-full bg-green-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transform hover:-translate-y-0.5 transition-all duration-300">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="relative z-10 bg-gradient-to-t from-black via-black/90 to-transparent py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center items-center gap-2 sm:gap-4">
                <img src="{{ asset('assets/images/LOGO-ANIMASI-01-500x500.png') }}" alt="AN" class="sm:h-10 h-7 hover:scale-110 transition-transform duration-300 filter hover:brightness-125">
                <img src="{{ asset('assets/images/TKJ-Baru-500x500.png') }}" alt="TJKT" class="sm:h-10 h-7 hover:scale-110 transition-transform duration-300 filter hover:brightness-125">
                <img src="{{ asset('assets/images/LOGO-RPL-01-500x500.png') }}" alt="PPLG" class="sm:h-10 h-7 hover:scale-110 transition-transform duration-300 filter hover:brightness-125">
                <img src="{{ asset('assets/images/LOGO-AKL-01-500x500.png') }}" alt="AKL" class="sm:h-10 h-7 hover:scale-110 transition-transform duration-300 filter hover:brightness-125">
                <img src="{{ asset('assets/images/BR-500x500.png') }}" alt="BR" class="sm:h-10 h-7 hover:scale-110 transition-transform duration-300 filter hover:brightness-125">
                <img src="{{ asset('assets/images/Logo-TB-OK-01-500x500.png') }}" alt="DPB" class="sm:h-10 h-7 hover:scale-110 transition-transform duration-300 filter hover:brightness-125">
                <img src="{{ asset('assets/images/LOGO-LPS-01-500x500.png') }}" alt="LPS" class="sm:h-10 h-7 hover:scale-110 transition-transform duration-300 filter hover:brightness-125">
                <img src="{{ asset('assets/images/MP-Baru-500x500.png') }}" alt="MP" class="sm:h-10 h-7 hover:scale-110 transition-transform duration-300 filter hover:brightness-125">
            </div>
        </div>
    </footer>
</body>
</html>