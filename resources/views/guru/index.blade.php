<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-home>
        <div class="container mx-auto px-4 py-8 mt-16">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Sistem Manajemen Absensi</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                        <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Isi Agenda Harian</h2>
                        <p class="text-gray-600 text-center mb-4">Catat dan kelola agenda kegiatan harian kelas dengan mudah.</p>
                        
                        <div class="flex justify-center">
                            <a 
                                href="{{ url('agenda') }}" 
                                class="inline-flex items-center justify-center px-5 py-3 bg-blue-600 text-white font-medium rounded-lg transition-all duration-300"
                                :class="{ 'bg-blue-700 transform scale-105': hover }"
                            >
                                <span>Mulai</span>
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
                        <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Isi Ketidakhadiran</h2>
                        <p class="text-gray-600 text-center mb-4">Laporkan izin atau sakit untuk hari ini dengan cepat dan terstruktur.</p>
                        
                        <div class="flex justify-center">
                            <a 
                                href="{{ url('absen_guru') }}"
                                class="inline-flex items-center justify-center px-5 py-3 bg-red-600 text-white font-medium rounded-lg transition-all duration-300"
                                :class="{ 'bg-red-700 transform scale-105': hover }"
                            >
                                <span>Laporkan</span>
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
                        <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Isi Absensi Siswa</h2>
                        <p class="text-gray-600 text-center mb-4">Catat kehadiran harian dan kumpulkan data absensi siswa dengan mudah.</p>
                        
                        <div class="flex justify-center">
                            <a 
                                href="{{ url('absensiswa_guru') }}" 
                                class="inline-flex items-center justify-center px-5 py-3 bg-green-600 text-white font-medium rounded-lg transition-all duration-300"
                                :class="{ 'bg-green-700 transform scale-105': hover }"
                            >
                                <span>Mulai</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-home>
</x-layout>