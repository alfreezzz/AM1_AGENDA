<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title }}</title>
  <link rel="icon" href="{{ asset('assets/images/icon.png') }}">
  @vite('resources/css/app.css')

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    
  </style>
</head>
<body class="bg-gray-100 font-sans antialiased h-screen overflow-y-auto">
  <div x-data="{ sidebarOpen: false }" class="back flex h-full">
    
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 w-64 bg-gray-800 text-white transform transition-transform duration-200 ease-in-out md:translate-x-0 flex flex-col z-30">
      <div class="flex items-center justify-center mt-3 mb-5 mx-3">
        <div class="flex items-center space-x-4">
          <img src="{{ asset('assets/images/icon.png') }}" alt="SMK Amaliah" class="w-12 h-12">
          <div>
              <h1 class="text-xs font-semibold leading-tight">SMK Amaliah 1&2 Ciawi</h1>
              <p class="italic text-left" style="font-size: 0.5rem;">Tauhid is Our Fundament</p>
          </div>
        </div>
      </div>
      <!-- Navigation -->
      <x-navigasi></x-navigasi>

      <form method="POST" action="{{ route('logout') }}" class="mt-auto p-4">
        @csrf
        <hr class="my-2 border-t-1 border-gray-300">
        <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm rounded-md hover:bg-red-500 focus:outline-none focus:bg-red-600">
          <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
          <span>Log out</span>
        </button>
      </form>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 ml-0 md:ml-64 transition-all duration-200 ease-in-out overflow-y-auto h-full">
      
      <!-- Header -->
      <header class="flex items-center justify-between h-16 bg-gray-800 text-white px-4 max-md:fixed top-0 w-full z-40" x-data="{ isNotificationOpen: false }">
        <!-- Burger Icon and Title -->
        <button @click="sidebarOpen = !sidebarOpen" @keyup.esc.window="sidebarOpen = !sidebarOpen" x-transition.origin.top.duration.300ms class="text-white focus:outline-none z-50 md:hidden">
          <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/></svg>
        </button>
        <div class="flex flex-grow justify-center text-center text-lg font-semibold  md:block">AM Agenda</div>
    
        <!-- Notifications -->
        @if (Auth::user()->role == 'Sekretaris')
            <div class="relative">
                <button @click="isNotificationOpen = !isNotificationOpen" class="relative rounded-full p-1 text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-3 focus:ring-offset-gray-800">
                    <span class="sr-only">View notifications</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    @if(Auth::user()->unreadNotifications->count())
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-red-400"></span>
                    @endif
                </button>
        
                <!-- Dropdown Notification Panel -->
                <div x-show="isNotificationOpen" @click.outside="isNotificationOpen = false" @keyup.esc.window="isNotificationOpen = false" x-transition.origin.top.duration.300ms class="absolute right-0 mt-2 w-72 bg-white rounded shadow-lg p-4 z-50 transition ease-out duration-150" x-cloak x-show.transition.opacity>
                    <h3 class="text-gray-800 font-semibold text-sm mb-2">Notifikasi</h3>
                    <hr class="mb-2">
                    @forelse (Auth::user()->unreadNotifications as $notification)
                        <div id="notification-{{ $notification->id }}" class="p-2 bg-white rounded hover:bg-gray-100 cursor-pointer mb-1 shadow-sm">
                            <p class="text-sm font-medium text-gray-800">{{ $notification->data['title'] }}</p>
                            <p class="text-xs text-gray-500">{{ $notification->data['message'] }}</p>
                            <a href="{{ $notification->data['link'] ?? '#' }}" class="text-blue-500 text-xs mt-1 inline-block">Lihat Detail</a>
                            <button onclick="deleteNotification('{{ $notification->id }}')" class="text-red-500 text-xs ml-2">Hapus</button>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada notifikasi baru.</p>
                    @endforelse
                </div>
            </div>
        @endif
      </header>    

      <!-- Page Content -->
      <div class="p-4 md:p-8 mt-16 md:mt-0">
        <x-header>{{ $title }}</x-header>
        <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
          {{ $slot }}
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<script>
  function deleteNotification(notificationId) {
      fetch(`/deleteNotification/${notificationId}`, {
          method: 'DELETE',
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
      }).then(response => {
          if (response.ok) {
              document.querySelector(`#notification-${notificationId}`).remove();
          } else {
              alert("Gagal menghapus notifikasi");
          }
      });
  }
</script>
