@php
    // Ambil slug dari kelas terkait pengguna, jika tersedia
    $kelasSlug = Auth::user()->kelas ? Auth::user()->kelas->slug : null;
@endphp
<nav class="flex flex-col space-y-2 px-4 flex-grow overflow-y-auto py-2 my-2 mb-4 scrollbar-hide max-lg:pt-20">
    <!-- Conditional Navigation Links based on User Role -->
    @if (Auth::user()->role == 'Admin')
      <a href="{{ url('admin') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('admin') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
          <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
        </svg>
        <span>Beranda</span>
      </a>  
      <a href="{{ url('mapel') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('mapel') || Request::is('mapel/create') || Request::is('mapel/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M6.012 18H21V4a2 2 0 0 0-2-2H6c-1.206 0-3 .799-3 3v14c0 2.201 1.794 3 3 3h15v-2H6.012C5.55 19.988 5 19.805 5 19s.55-.988 1.012-1zM8 6h9v2H8V6z"></path></svg>
        <span>Mapel</span>
      </a>
      <a href="{{ url('jurusan') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('jurusan') || Request::is('jurusan/create') || Request::is('jurusan/*/edit') || Request::is('jurusan/*/kelas') || Request::is('kelas/create') || Request::is('kelas/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" ><path fill="currentColor" d="M224 128v704h576V128zm-32-64h640a32 32 0 0 1 32 32v768a32 32 0 0 1-32 32H192a32 32 0 0 1-32-32V96a32 32 0 0 1 32-32"></path><path fill="currentColor" d="M64 832h896v64H64zm256-640h128v96H320z"></path><path fill="currentColor" d="M384 832h256v-64a128 128 0 1 0-256 0zm128-256a192 192 0 0 1 192 192v128H320V768a192 192 0 0 1 192-192M320 384h128v96H320zm256-192h128v96H576zm0 192h128v96H576z"></path></svg>
        <span>Kelas & Jurusan</span>
      </a>
      <a href="{{ url('data_siswa') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('data_siswa') || Request::is('data_siswa/create') || Request::is('data_siswa/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" style="color:#FFFFFF;" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.00003 9C6.1046 9 7.00003 8.10457 7.00003 7C7.00003 5.89543 6.1046 5 5.00003 5C3.89546 5 3.00003 5.89543 3.00003 7C3.00003 8.10457 3.89546 9 5.00003 9ZM5.00003 10C6.65688 10 8.00003 8.65685 8.00003 7C8.00003 5.34315 6.65688 4 5.00003 4C3.34318 4 2.00003 5.34315 2.00003 7C2.00003 8.65685 3.34318 10 5.00003 10Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M3.85355 8.89645C4.04882 9.09171 4.04882 9.40829 3.85355 9.60355L3.51612 9.94098C3.13529 10.3218 2.84835 10.7861 2.67803 11.297C2.56011 11.6508 2.5 12.0212 2.5 12.3941V14.25C2.5 14.5262 2.27614 14.75 2 14.75C1.72386 14.75 1.5 14.5262 1.5 14.25V12.3941C1.5 11.9138 1.57744 11.4365 1.72935 10.9808C1.94876 10.3226 2.3184 9.72449 2.80902 9.23388L3.14645 8.89645C3.34171 8.70118 3.65829 8.70118 3.85355 8.89645Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M15.6464 8.59646C15.4512 8.79172 15.4512 9.1083 15.6464 9.30357L15.9839 9.641C16.3647 10.0218 16.6517 10.4861 16.822 10.9971C16.9399 11.3508 17 11.7213 17 12.0941V14.25C17 14.5261 17.2239 14.75 17.5 14.75C17.7761 14.75 18 14.5261 18 14.25V12.0941C18 11.6138 17.9226 11.1365 17.7707 10.6808C17.5512 10.0226 17.1816 9.4245 16.691 8.93389L16.3536 8.59646C16.1583 8.4012 15.8417 8.4012 15.6464 8.59646Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14 9C12.8955 9 12 8.10457 12 7C12 5.89543 12.8955 5 14 5C15.1046 5 16 5.89543 16 7C16 8.10457 15.1046 9 14 9ZM14 10C12.3432 10 11 8.65685 11 7C11 5.34315 12.3432 4 14 4C15.6569 4 17 5.34315 17 7C17 8.65685 15.6569 10 14 10Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M9.50006 13.25C8.11933 13.25 7.00002 14.3693 7.00001 15.75L7 17.05C7 17.3261 6.77614 17.55 6.5 17.55C6.22385 17.55 6 17.3261 6 17.05L6.00001 15.75C6.00002 13.817 7.56704 12.25 9.50006 12.25C11.433 12.25 13 13.817 13 15.75V17.05C13 17.3261 12.7762 17.55 12.5 17.55C12.2239 17.55 12 17.3261 12 17.05V15.75C12 14.3693 10.8808 13.25 9.50006 13.25Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M9.50003 11.75C10.6046 11.75 11.5 10.8546 11.5 9.75C11.5 8.64543 10.6046 7.75 9.50003 7.75C8.39546 7.75 7.50003 8.64543 7.50003 9.75C7.50003 10.8546 8.39546 11.75 9.50003 11.75ZM9.50003 12.75C11.1569 12.75 12.5 11.4069 12.5 9.75C12.5 8.09315 11.1569 6.75 9.50003 6.75C7.84318 6.75 6.50003 8.09315 6.50003 9.75C6.50003 11.4069 7.84318 12.75 9.50003 12.75Z" fill="currentColor"/></svg>
        <span>Siswa</span>
      </a>
      <a href="{{ url('user') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('user') || Request::is('user/create') || Request::is('user/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M406.5 399.6C387.4 352.9 341.5 320 288 320l-64 0c-53.5 0-99.4 32.9-118.5 79.6C69.9 362.2 48 311.7 48 256C48 141.1 141.1 48 256 48s208 93.1 208 208c0 55.7-21.9 106.2-57.5 143.6zm-40.1 32.7C334.4 452.4 296.6 464 256 464s-78.4-11.6-110.5-31.7c7.3-36.7 39.7-64.3 78.5-64.3l64 0c38.8 0 71.2 27.6 78.5 64.3zM256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-272a40 40 0 1 1 0-80 40 40 0 1 1 0 80zm-88-40a88 88 0 1 0 176 0 88 88 0 1 0 -176 0z"/></svg>
        <span>User</span>
      </a>
      <a href="{{ url('jadwal_pelajaran') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('jadwal_pelajaran') || Request::is('jadwal_pelajaran/create') || Request::is('jadwal_pelajaran/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2"  mlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff"   d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L64 64C28.7 64 0 92.7 0 128l0 16 0 48L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-256 0-48 0-16c0-35.3-28.7-64-64-64l-40 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L152 64l0-40zM48 192l352 0 0 256c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16l0-256z"/></svg>
        <span>Jadwal Pelajaran</span>
      </a>
      <hr class="my-4 border-t-1 border-gray-300">
      <div x-data="{ open: false }" class="relative">
        <button 
          @click="open = !open" 
          class="flex items-center w-full text-left px-4 py-2 rounded-md text-sm  outline-none
          {{ Request::is('agenda') || Request::is('agenda/kelas/*') || Request::is('absen_guru') || Request::is('absen_guru/kelas/*') || Request::is('absen_siswa') || Request::is('absen_siswa/kelas/*') || Request::is('absen_siswa/create') || Request::is('absen_siswa/*/edit') || Request::is('absensiswa_guru') || Request::is('absensiswa_guru/kelas/*') ? 'bg-green-500 text-white' : 'hover:bg-green-500 text-gray-300' }}">
          <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path fill="#ffffff" d="M75 75L41 41C25.9 25.9 0 36.6 0 57.9L0 168c0 13.3 10.7 24 24 24l110.1 0c21.4 0 32.1-25.9 17-41l-30.8-30.8C155 85.5 203 64 256 64c106 0 192 86 192 192s-86 192-192 192c-40.8 0-78.6-12.7-109.7-34.4c-14.5-10.1-34.4-6.6-44.6 7.9s-6.6 34.4 7.9 44.6C151.2 495 201.7 512 256 512c141.4 0 256-114.6 256-256S397.4 0 256 0C185.3 0 121.3 28.7 75 75zm181 53c-13.3 0-24 10.7-24 24l0 104c0 6.4 2.5 12.5 7 17l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-65-65 0-94.1c0-13.3-10.7-24-24-24z"/>
          </svg>
          <span>Log Aktivitas</span>
          <svg :class="{ 'rotate-180': open }" class="ml-auto w-5 h-5 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
          </svg>
        </button>
      
        <div 
          x-show="open" 
          @click.outside="open = false" @keyup.esc.window="open = false" x.transition.origin.top
          x-transition:enter="transition ease-out duration-100"
          x-transition:enter-start="opacity-0 scale-95"
          x-transition:enter-end="opacity-100 scale-100"
          x-transition:leave="transition ease-in duration-75"
          x-transition:leave-start="opacity-100 scale-100"
          x-transition:leave-end="opacity-0 scale-95"
          class="absolute left-0 mt-1 w-full bg-white shadow-md rounded-md z-10">
      
          <a href="{{ url('agenda') }}" class="flex items-center px-4 py-2 text-sm {{ Request::is('agenda') || Request::is('agenda/kelas/*') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-green-100' }}">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="8" height="4" x="8" y="2" rx="1" />
              <path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-.5" />
              <path d="M16 4h2a2 2 0 0 1 1.73 1" />
              <path d="M8 18h1" />
              <path d="M21.378 12.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
            </svg>
            <span>Agenda</span>
          </a>
      
          <a href="{{ url('absen_guru') }}" class="flex items-center px-4 py-2 text-sm {{ Request::is('absen_guru') || Request::is('absen_guru/kelas/*') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-green-100' }}">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="7" r="5" />
              <path d="M17 22H5.266a2 2 0 0 1-1.985-2.248l.39-3.124A3 3 0 0 1 6.649 14H7" />
              <path d="M21 18l-3-3m3 0l-3 3" />
            </svg>
            <span>Absensi Guru</span>
          </a>
      
          <a href="{{ url('absen_siswa') }}" class="flex items-center px-4 py-2 text-sm {{ Request::is('absen_siswa') || Request::is('absen_siswa/kelas/*') || Request::is('absen_siswa/create') || Request::is('absen_siswa/*/edit') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-green-100' }}">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 7S9 1 2 6v22c7-5 14 0 14 0s7-5 14 0V6c-7-5-14 1-14 1m0 0v21" />
            </svg>
            <span>Absensi Siswa (Sekretaris)</span>
          </a>
      
          <a href="{{ url('absensiswa_guru') }}" class="flex items-center px-4 py-2 text-sm {{ Request::is('absensiswa_guru') || Request::is('absensiswa_guru/kelas/*') ? 'bg-green-500 text-white' : 'text-gray-700 hover:bg-green-100' }}">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 7S9 1 2 6v22c7-5 14 0 14 0s7-5 14 0V6c-7-5-14 1-14 1m0 0v21" />
            </svg>
            <span>Absensi Siswa (Guru)</span>
          </a>
        </div>
      </div>      
    @elseif (Auth::user()->role == 'Guru')
      <a href="{{ url('guru') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('guru') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
          <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
        </svg>
        <span>Beranda</span>
      </a>
      <a href="{{ url('agenda') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('agenda') || Request::is('agenda/kelas/*') || Request::is('agenda/create/*') || Request::is('agenda/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-pen-line"><rect width="8" height="4" x="8" y="2" rx="1"/><path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-.5"/><path d="M16 4h2a2 2 0 0 1 1.73 1"/><path d="M8 18h1"/><path d="M21.378 12.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/></svg>
        <span>Agenda</span>
      </a>
      <a href="{{ url('absen_guru') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('absen_guru') || Request::is('absen_guru/kelas/*') || Request::is('absen_guru/create/*') || Request::is('absen_guru/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ai ai-PersonCross"><circle cx="12" cy="7" r="5"/><path d="M17 22H5.266a2 2 0 0 1-1.985-2.248l.39-3.124A3 3 0 0 1 6.649 14H7"/><path d="M21 18l-3-3m3 0l-3 3"/></svg>
        <span>Absensi Guru</span>
      </a>
      <a href="{{ url('absensiswa_guru') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('absensiswa_guru') || Request::is('absensiswa_guru/kelas/*') || Request::is('absensiswa_guru/create/*') || Request::is('absensiswa_guru/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7S9 1 2 6v22c7-5 14 0 14 0s7-5 14 0V6c-7-5-14 1-14 1m0 0v21"/></svg>
        <span>Absensi Siswa (Guru)</span>
      </a>
      <hr class="my-4 border-t-1 border-gray-300">
      <a href="{{ url('absen_siswa') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('absen_siswa') || Request::is('absen_siswa/kelas/*') || Request::is('absen_siswa/create') || Request::is('absen_siswa/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7S9 1 2 6v22c7-5 14 0 14 0s7-5 14 0V6c-7-5-14 1-14 1m0 0v21"/></svg>
        <span>Absensi Siswa (Sekretaris)</span>
      </a>
      <a href="{{ url('jadwal_pelajaran') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('jadwal_pelajaran') || Request::is('jadwal_pelajaran/create') || Request::is('jadwal_pelajaran/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2"  mlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff"   d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L64 64C28.7 64 0 92.7 0 128l0 16 0 48L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-256 0-48 0-16c0-35.3-28.7-64-64-64l-40 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L152 64l0-40zM48 192l352 0 0 256c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16l0-256z"/></svg>
        <span>Jadwal Pelajaran</span>
      </a>
    @elseif (Auth::user()->role == 'Sekretaris')
      <a href="{{ url('siswa') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('siswa') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
          <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
        </svg>
        <span>Beranda</span>
      </a>
      <a href="{{ $kelasSlug ? url('absen_siswa/kelas/' . $kelasSlug) : '#' }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('absen_siswa/kelas/' . $kelasSlug) || Request::is('absen_siswa/kelas/*') || Request::is('absen_siswa') || Request::is('absen_siswa/create') || Request::is('absen_siswa/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7S9 1 2 6v22c7-5 14 0 14 0s7-5 14 0V6c-7-5-14 1-14 1m0 0v21"/></svg>
        <span>Absensi</span>
      </a>
      <a href="{{ $kelasSlug ? url('absen_guru/kelas/' . $kelasSlug) : '#' }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('absen_guru/kelas/' . $kelasSlug) || Request::is('absen_guru/kelas/*') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="m438-240 226-226-58-58-169 169-84-84-57 57 142 142ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>
        <span>Tugas</span>
    </a>
    <hr class="my-4 border-t-1 border-gray-300">
    <a href="{{ url('jadwal_pelajaran') }}" class="flex items-center px-4 py-2 rounded-md text-sm {{ Request::is('jadwal_pelajaran') || Request::is('jadwal_pelajaran/create') || Request::is('jadwal_pelajaran/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
      <svg class="w-5 h-5 mr-2"  mlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff"   d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L64 64C28.7 64 0 92.7 0 128l0 16 0 48L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-256 0-48 0-16c0-35.3-28.7-64-64-64l-40 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L152 64l0-40zM48 192l352 0 0 256c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16l0-256z"/></svg>
      <span>Jadwal Pelajaran</span>
    </a>
    @endif
</nav>
