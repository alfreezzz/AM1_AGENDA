@php
    // Ambil slug dari kelas terkait pengguna, jika tersedia
    $kelasSlug = Auth::user()->kelas ? Auth::user()->kelas->slug : null;
@endphp
<nav class="flex flex-col space-y-2 px-4 flex-grow py-2 my-2 mb-4 max-lg:pt-20">
      <a href="{{ url('siswa') }}" class="flex items-center w-full px-4 py-2 text-sm text-white rounded-lg transition-colors duration-200 hover:bg-green-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:ring-offset-gray-800 group {{ Request::is('siswa') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
          <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
        </svg>
        <span>Beranda</span>
      </a>
      <a href="{{ $kelasSlug ? url('absen_siswa/kelas/' . $kelasSlug) : '#' }}" class="flex items-center w-full px-4 py-2 text-sm text-white rounded-lg transition-colors duration-200 hover:bg-green-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:ring-offset-gray-800 group {{ Request::is('absen_siswa/kelas/' . $kelasSlug) || Request::is('absen_siswa/kelas/*') || Request::is('absen_siswa') || Request::is('absen_siswa/create') || Request::is('absen_siswa/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7S9 1 2 6v22c7-5 14 0 14 0s7-5 14 0V6c-7-5-14 1-14 1m0 0v21"/></svg>
        <span>Absensi</span>
      </a>
      <a href="{{ $kelasSlug ? url('absen_guru/kelas/' . $kelasSlug) : '#' }}" class="flex items-center w-full px-4 py-2 text-sm text-white rounded-lg transition-colors duration-200 hover:bg-green-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:ring-offset-gray-800 group {{ Request::is('absen_guru/kelas/' . $kelasSlug) || Request::is('absen_guru/kelas/*') ? 'bg-green-500' : 'hover:bg-green-500' }}">
        <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="m438-240 226-226-58-58-169 169-84-84-57 57 142 142ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>
        <span>Tugas</span>
    </a>
    <hr class="my-4 border-t-1 border-gray-300">
    <a href="{{ url('jadwal_pelajaran') }}" class="flex items-center w-full px-4 py-2 text-sm text-white rounded-lg transition-colors duration-200 hover:bg-green-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:ring-offset-gray-800 group {{ Request::is('jadwal_pelajaran') || Request::is('jadwal_pelajaran/create') || Request::is('jadwal_pelajaran/*/edit') ? 'bg-green-500' : 'hover:bg-green-500' }}">
      <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-300"  mlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff"   d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L64 64C28.7 64 0 92.7 0 128l0 16 0 48L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-256 0-48 0-16c0-35.3-28.7-64-64-64l-40 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L152 64l0-40zM48 192l352 0 0 256c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16l0-256z"/></svg>
      <span>Jadwal Pelajaran</span>
    </a>
</nav>
