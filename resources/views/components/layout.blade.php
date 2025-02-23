<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        
        .sidebar-animation {
            animation: slideIn 0.3s ease-out;
        }
        
        .notification-dot {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(0.95); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
            100% { transform: scale(0.95); opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased h-screen">
    <div x-data="{ sidebarOpen: false }" class="flex h-full">
        <!-- Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             @keyup.esc.window="sidebarOpen = false"
             class="fixed inset-0 bg-black bg-opacity-50 transition-opacity lg:hidden z-20"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-gray-800 to-gray-900 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col z-30 overflow-y-auto">
            <div class="flex items-center justify-center p-4 border-b border-gray-700 max-lg:hidden">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/images/icon.png') }}" alt="SMK Amaliah" class="w-12 h-12 rounded-lg shadow-lg">
                    <div>
                        <h1 class="text-sm font-bold leading-tight">SMK Amaliah 1&2 Ciawi Bogor</h1>
                        <p class="text-xs italic text-gray-400">Tauhid is Our Fundament</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <x-navigasi></x-navigasi>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="p-4 mt-auto border-t border-gray-700">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-white rounded-lg transition-colors duration-200 hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 group">
                    <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Log out</span>
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-0 overflow-y-auto h-full">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 fixed top-0 left-0 w-full z-40 lg:w-[calc(100%-16rem)] lg:left-64" x-data="{ isNotificationOpen: false }">
                <div class="flex items-center justify-between h-16 px-4 lg:px-8">
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-600 lg:hidden focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-md p-1">
                        <svg class="sm:w-6 sm:h-6 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Page Title -->
                    <h1 class="lg:text-xl text-base sm:text-lg font-semibold text-gray-800 flex-1 text-center tracking-wide">{{ $title }}</h1>

                    <!-- Notifications -->
                    @if (Auth::user()->role == 'Sekretaris')
                    <div class="relative">
                        <button @click="isNotificationOpen = !isNotificationOpen" 
                                class="relative p-2 text-gray-600 hover:text-gray-800 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                            <span class="sr-only">View notifications</span>
                            <svg class="sm:w-6 sm:h-6 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if(Auth::user()->unreadNotifications->count())
                            <span class="absolute top-1 right-1 block h-2.5 w-2.5 rounded-full bg-red-500 notification-dot"></span>
                            @endif
                        </button>

                        <!-- Notifications Dropdown -->
                        <div x-show="isNotificationOpen" 
                             @click.outside="isNotificationOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-3 sm:w-96 w-64 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                            <div class="p-4">
                                <h3 class="text-gray-900 font-medium mb-2 text-sm sm:text-base">Notifikasi</h3>
                                <div class="divide-y divide-gray-200">
                                    @forelse (Auth::user()->unreadNotifications as $notification)
                                    <div id="notification-{{ $notification->id }}" class="py-3">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="sm:text-sm text-xs font-medium text-gray-900">{{ $notification->data['title'] }}</p>
                                                <p class="sm:text-sm text-xs text-gray-600 mt-1">{{ $notification->data['message'] }}</p>
                                                <a href="{{ $notification->data['link'] ?? '#' }}" class="sm:text-sm text-xs text-blue-600 hover:text-blue-800 mt-2 inline-block">Lihat Detail</a>
                                            </div>
                                            <button onclick="deleteNotification('{{ $notification->id }}')" class="text-gray-400 hover:text-red-500 transition-colors duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    @empty
                                    <p class="py-4 sm:text-sm text-xs text-gray-500 text-center">Tidak ada notifikasi baru.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="px-4 lg:px-6 pt-20">
              {{-- <x-header>{{ $title }}</x-header> --}}
              <div class="bg-white shadow-md rounded-lg p-4">
                {{ $slot }}
              </div>
            </main>
        </div>
    </div>

    <script>
        function deleteNotification(notificationId) {
            fetch(`/deleteNotification/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    const element = document.querySelector(`#notification-${notificationId}`);
                    element.style.animation = 'fadeOut 0.3s ease-out';
                    setTimeout(() => element.remove(), 300);
                } else {
                    throw new Error('Failed to delete notification');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghapus notifikasi');
            });
        }
    </script>
</body>
</html>