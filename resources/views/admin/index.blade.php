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
                <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik Sistem</h2>
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
                <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Log Aktivitas</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Agenda Harian CTA -->
                    <div 
                        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                    >
                        <div class="p-6">
                            <div class="h-16 w-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Lihat Agenda Harian</h2>
                            
                            <div class="flex justify-center">
                                <a 
                                    href="{{ url('agenda') }}" 
                                    class="inline-flex items-center justify-center px-5 py-3 bg-blue-600 text-white font-medium rounded-lg transition-all duration-300"
                                    :class="{ 'bg-blue-700 transform scale-105': hover }"
                                >
                                    <span>Lihat</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
    
                    <!-- Ketidakhadiran CTA -->
                    <div 
                        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                    >
                        <div class="p-6">
                            <div class="h-16 w-16 bg-red-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Lihat Ketidakhadiran Guru</h2>
                            
                            <div class="flex justify-center">
                                <a 
                                    href="{{ url('absen_guru') }}"
                                    class="inline-flex items-center justify-center px-5 py-3 bg-red-600 text-white font-medium rounded-lg transition-all duration-300"
                                    :class="{ 'bg-red-700 transform scale-105': hover }"
                                >
                                    <span>Lihat</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
    
                    <!-- Absensi Siswa CTA -->
                    <div 
                        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                    >
                        <div class="p-6">
                            <div class="h-16 w-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Lihat Absensi Siswa dari Sekretaris</h2>
                            
                            <div class="flex justify-center">
                                <a 
                                    href="{{ url('absen_siswa') }}" 
                                    class="inline-flex items-center justify-center px-5 py-3 bg-green-600 text-white font-medium rounded-lg transition-all duration-300"
                                    :class="{ 'bg-green-700 transform scale-105': hover }"
                                >
                                    <span>Lihat</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Daily Attendance CTA -->
                    <div 
                        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                    >
                        <div class="p-6">
                            <div class="h-16 w-16 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Lihat Absensi Siswa dari Guru</h2>
                            
                            <div class="flex justify-center">
                                <a 
                                    href="{{ route('absensiswa_guru.index') }}" 
                                    class="inline-flex items-center justify-center px-5 py-3 bg-yellow-600 text-white font-medium rounded-lg transition-all duration-300"
                                    :class="{ 'bg-yellow-700 transform scale-105': hover }"
                                >
                                    <span>Lihat</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-home>
</x-layout>