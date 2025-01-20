<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Gradient only for footer */
        .footer-gradient {
            background: linear-gradient(to top, rgb(0, 0, 0), rgba(0, 0, 0, 0));
        }
    </style>
</head>
<body class="bg-black min-h-screen relative flex flex-col justify-between">
    <!-- Background Image -->
    <div class="absolute inset-0 w-full h-full object-cover">
        <img src="{{ asset('assets/images/am_bg.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-50" alt="Background Image">
    </div>

    <!-- Content Area Centered -->
    <div class="relative z-10 flex-grow flex items-center justify-center">
        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-6 w-120 mx-auto text-center text-white py-12 border">
            <!-- School Logo Flex Layout -->
            <div class="flex flex-col items-center justify-center mb-6">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('assets/images/icon.png') }}" alt="SMK Amaliah" class="w-16 h-16">  <!-- School logo smaller -->
                    <div>
                        <h1 class="text-2xl font-serif">SMK Amaliah 1&2 Ciawi</h1>
                        <p class="text-sm italic text-left">Tauhid is Our Fundament</p>
                    </div>
                </div>
            </div>

            <!-- Login Form -->
            <form action="{{ url('login') }}" method="post" class="mt-6 space-y-4">
                @csrf
                <!-- Username -->
                <div>
                    <label for="name" class="block text-sm text-left">Nama</label>
                    <input type="text" class="mt-1 block mb-5 w-full h-9 bg-white text-black rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Nama" style="padding-left: 10px">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 text-left">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm text-left">Password</label>
                    <div class="relative">
                        <!-- Password Input -->
                        <input type="password" class="mt-1 block w-full h-10 bg-white text-black rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm @error('password') border-red-500 @enderror" id="password" name="password" value="{{ old('password') }}" style="padding-left: 10px;">
                        
                        <!-- Eye Icon -->
                        <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility('password', 'togglePasswordIcon')">
                            <i id="togglePasswordIcon" class="fas fa-eye text-gray-600"></i>
                        </span>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 text-left">{{ $message }}</p>
                    @enderror
                </div>  
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label for="remember" class="text-sm">Ingat Saya</label>
                </div>              

                <!-- Submit Button -->
                <button type="submit" class="w-full border bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 transition">Login</button>
            </form>
        </div>
    </div>

  <!-- Footer always at the bottom -->
<footer class="relative z-10 footer-gradient flex justify-center space-x-4 py-6 text-white w-full">
    <img src="{{ asset('assets/images/LOGO-ANIMASI-01-500x500.png') }}" alt="AN" class="h-8 glow">
    <img src="{{ asset('assets/images/TKJ-Baru-500x500.png') }}" alt="TJKT" class="h-6 glow">
    <img src="{{ asset('assets/images/LOGO-RPL-01-500x500.png') }}" alt="PPLG" class="h-8 glow">
    <img src="{{ asset('assets/images/LOGO-AKL-01-500x500.png') }}" alt="AKL" class="h-8 glow">
    <img src="{{ asset('assets/images/BR-500x500.png') }}" alt="BR" class="h-8 glow">
    <img src="{{ asset('assets/images/Logo-TB-OK-01-500x500.png') }}" alt="DPB" class="h-8 glow">
    <img src="{{ asset('assets/images/LOGO-LPS-01-500x500.png') }}" alt="LPS" class="h-8 glow">
    <img src="{{ asset('assets/images/MP-Baru-500x500.png') }}" alt="MP" class="h-8 glow">
</footer>

<style>
    .glow {
        filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.212)); /* Adds a soft white glow */
    }
</style>
<script>
    function togglePasswordVisibility(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>

</body>
</html>
