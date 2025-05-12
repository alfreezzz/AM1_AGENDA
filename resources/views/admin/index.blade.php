<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-home>
        <div 
            x-data="{
                totalMapel: {{ $totalMapel }},
                totalKelas: {{ $totalKelas }},
                totalJurusan: {{ $totalJurusan }},
                totalUser: {{ $totalUser }}
            }" 
            class="bg-gray-100 py-8 px-4 sm:px-6 lg:px-8 rounded-lg mt-16"
        >
            <!-- Stats Overview -->
            <div class="mb-4">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Statistik Sistem</h1>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Total Mapel Card -->
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="rounded-full bg-blue-100 p-3 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-blue-600">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Total Mapel</div>
                                <div class="text-2xl font-semibold text-gray-800">{{ $totalMapel }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Kelas Card -->
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="rounded-full bg-green-100 p-3 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-green-600">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Total Kelas</div>
                                <div class="text-2xl font-semibold text-gray-800">{{ $totalKelas }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Jurusan Card -->
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="rounded-full bg-yellow-100 p-3 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-yellow-600">
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                    <path d="M12 11h4"></path>
                                    <path d="M12 16h4"></path>
                                    <path d="M8 11h.01"></path>
                                    <path d="M8 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Total Jurusan</div>
                                <div class="text-2xl font-semibold text-gray-800">{{ $totalJurusan }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total User Card -->
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="rounded-full bg-purple-100 p-3 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-purple-600">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <circle cx="12" cy="10" r="3"></circle>
                                    <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Total User</div>
                                <div class="text-2xl font-semibold text-gray-800">{{ $totalUser }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto px-4 py-8 mt-16">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Log Aktivitas</h1>
                </div>
                <!-- Action Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Agenda Harian CTA Card -->
                    <div 
                        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                    >
                        <div class="relative h-40 bg-gradient-to-r from-blue-500 to-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 h-full w-full text-white opacity-10" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Z"></path>
                            </svg>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <h2 class="text-2xl font-bold text-white">Agenda Harian</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 mb-4">Lihat dan kelola semua agenda kegiatan sekolah dalam satu tempat.</p>
                            <div class="flex justify-between items-center">
                                <a 
                                    href="{{ url('agenda') }}" 
                                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg transition-all duration-300"
                                    :class="{ 'bg-blue-700 transform scale-105': hover }"
                                >
                                    <span>Lihat Agenda</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <span class="text-sm text-gray-500">5 agenda hari ini</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ketidakhadiran Guru CTA Card -->
                    <div 
                        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                    >
                        <div class="relative h-40 bg-gradient-to-r from-red-500 to-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 h-full w-full text-white opacity-10" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"></path>
                            </svg>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <h2 class="text-2xl font-bold text-white">Ketidakhadiran Guru</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 mb-4">Pantau ketidakhadiran guru dan cek status penggantinya.</p>
                            <div class="flex justify-between items-center">
                                <a 
                                    href="{{ url('absen_guru') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg transition-all duration-300"
                                    :class="{ 'bg-red-700 transform scale-105': hover }"
                                >
                                    <span>Lihat Absensi</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <span class="text-sm text-gray-500">2 guru tidak hadir</span>
                            </div>
                        </div>
                    </div>

                    <!-- Absensi Siswa (Sekretaris) CTA Card -->
                    <div 
                        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                    >
                        <div class="relative h-40 bg-gradient-to-r from-green-500 to-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 h-full w-full text-white opacity-10" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M64,140a7.9,7.9,0,0,1-8,8H40a8,8,0,0,1,0-16H56A7.9,7.9,0,0,1,64,140Zm112,24H160a8,8,0,0,0,0,16h16a8,8,0,0,0,0-16Zm-64,0H96a8,8,0,0,0,0,16h16a8,8,0,0,0,0-16Zm-64,0H32a8,8,0,0,0,0,16H48a8,8,0,0,0,0-16Zm200-80H184V52a12,12,0,0,0-12-12H84A12,12,0,0,0,72,52V84H32a12,12,0,0,0-12,12V208a12,12,0,0,0,12,12H216a12,12,0,0,0,12-12V96A12,12,0,0,0,216,84ZM88,56h80V84H88ZM212,204H44V100H212Zm-56-44a8,8,0,0,1-8,8H160a8,8,0,0,1,0-16h16A8,8,0,0,1,164,160Zm-48-8H96a8,8,0,0,1,0,16h16a8,8,0,0,1,0-16Zm-64,0H32a8,8,0,0,1,0,16H48a8,8,0,0,1,0-16Zm112-24H160a8,8,0,0,1,0,16h16a8,8,0,0,1,0-16Zm-64,0H96a8,8,0,0,1,0,16h16a8,8,0,0,1,0-16Z"></path>
                            </svg>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <h2 class="text-2xl font-bold text-white">Absensi Siswa</h2>
                                <p class="text-green-100">Dari Sekretaris</p>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 mb-4">Lihat data kehadiran siswa yang dilaporkan oleh sekretaris kelas.</p>
                            <div class="flex justify-between items-center">
                                <a 
                                    href="{{ url('absen_siswa') }}" 
                                    class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg transition-all duration-300"
                                    :class="{ 'bg-green-700 transform scale-105': hover }"
                                >
                                    <span>Lihat Absensi</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <span class="text-sm text-gray-500">8 kelas tercatat</span>
                            </div>
                        </div>
                    </div>

                    <!-- Absensi Siswa (Guru) CTA Card -->
                    <div 
                        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                    >
                        <div class="relative h-40 bg-gradient-to-r from-yellow-500 to-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 h-full w-full text-white opacity-10" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M251.76,88.94l-120-64a8,8,0,0,0-7.52,0l-120,64a8,8,0,0,0,0,14.12L32,117.87v48.42a15.91,15.91,0,0,0,4.06,10.65C49.16,191.53,78.51,216,128,216s78.84-24.47,91.94-39.06a15.91,15.91,0,0,0,4.06-10.65V117.87l16-8.53V152a8,8,0,0,0,16,0V104.06A8,8,0,0,0,251.76,88.94ZM208,166.29c-8.44,9.37-32.28,27.51-72,29.59V120a8,8,0,0,0-16,0v75.88c-39.72-2.08-63.56-20.22-72-29.59V122.46l72,38.4a8,8,0,0,0,7.52,0l72-38.4ZM128,144.7,37.73,96,128,47.3,218.27,96Z"></path>
                            </svg>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <h2 class="text-2xl font-bold text-white">Absensi Siswa</h2>
                                <p class="text-yellow-100">Dari Guru</p>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 mb-4">Akses data absensi siswa yang diinput oleh guru mata pelajaran.</p>
                            <div class="flex justify-between items-center">
                                <a 
                                    href="{{ route('absensiswa_guru.index') }}" 
                                    class="inline-flex items-center justify-center px-4 py-2 bg-yellow-600 text-white font-medium rounded-lg transition-all duration-300"
                                    :class="{ 'bg-yellow-700 transform scale-105': hover }"
                                >
                                    <span>Lihat Absensi</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <span class="text-sm text-gray-500">12 laporan hari ini</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-home>
</x-layout>