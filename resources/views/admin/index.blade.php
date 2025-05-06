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
        </div>
    </x-home>
</x-layout>