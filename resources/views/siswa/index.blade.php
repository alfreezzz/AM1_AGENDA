<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-home>
        @php
            // Ambil slug dari kelas terkait pengguna, jika tersedia
            $kelasSlug = Auth::user()->kelas ? Auth::user()->kelas->slug : null;
        @endphp
        <div class="container mx-auto px-4 py-8 mt-16">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Sistem Manajemen Absensi</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Daily Attendance CTA -->
                <div 
                    class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                    x-data="{ hover: false }"
                    @mouseenter="hover = true"
                    @mouseleave="hover = false"
                >
                    <div class="p-6">
                        <div class="h-16 w-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Isi Absensi Harian</h2>
                        <p class="text-gray-600 text-center mb-4">Catat kehadiran harian dan kumpulkan data absensi siswa dengan mudah.</p>
                        
                        <div class="flex justify-center">
                            <a 
                                href="{{ route('absen_siswa.create') }}" 
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
    
                <!-- Class Attendance Report CTA -->
                <div 
                    class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                    x-data="{ hover: false }"
                    @mouseenter="hover = true"
                    @mouseleave="hover = false"
                >
                    <div class="p-6">
                        <div class="h-16 w-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Rekapan Absensi Kelas</h2>
                        <p class="text-gray-600 text-center mb-4">Lihat laporan kehadiran kelas dan analisis data absensi siswa.</p>
                        
                        <div class="flex justify-center">
                            <a 
                                href="{{ $kelasSlug ? url('absen_siswa/kelas/' . $kelasSlug . '/rekapan') : '#' }}"
                                class="inline-flex items-center justify-center px-5 py-3 bg-green-600 text-white font-medium rounded-lg transition-all duration-300"
                                :class="{ 'bg-green-700 transform scale-105': hover }"
                            >
                                <span>Lihat Laporan</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
    
                <!-- Assignments CTA -->
                <div 
                    class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                    x-data="{ hover: false }"
                    @mouseenter="hover = true"
                    @mouseleave="hover = false"
                >
                    <div class="p-6">
                        <div class="h-16 w-16 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Lihat Tugas</h2>
                        <p class="text-gray-600 text-center mb-4">Akses semua tugas yang diberikan dan pantau perkembangan siswa.</p>
                        
                        <div class="flex justify-center">
                            <a 
                                href="{{ $kelasSlug ? url('absen_guru/kelas/' . $kelasSlug) : '#' }}" 
                                class="inline-flex items-center justify-center px-5 py-3 bg-purple-600 text-white font-medium rounded-lg transition-all duration-300"
                                :class="{ 'bg-purple-700 transform scale-105': hover }"
                            >
                                <span>Lihat Tugas</span>
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