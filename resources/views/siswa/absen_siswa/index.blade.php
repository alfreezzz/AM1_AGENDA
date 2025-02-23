<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="min-h-screen pb-8">
        @if(auth()->user()->role === 'Admin')
            <div class="container mx-auto px-4 flex justify-end mb-8 space-x-4 text-xs sm:text-base">
                <a href="{{ url()->current() }}" 
                    class="px-6 py-2 rounded-full font-medium transition-all duration-300 transform hover:scale-105
                        {{ request()->query('show_all') 
                            ? 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-md' 
                            : 'bg-green-500 text-white hover:bg-green-600 shadow-lg hover:shadow-green-200' }}">
                    Tahun Ajaran Sekarang
                </a>
                <a href="{{ url()->current() }}?show_all=true" 
                    class="px-6 py-2 rounded-full font-medium transition-all duration-300 transform hover:scale-105
                        {{ request()->query('show_all') 
                            ? 'bg-green-500 text-white hover:bg-green-600 shadow-lg hover:shadow-green-200' 
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-md' }}">
                    Semua Tahun Ajaran
                </a>
            </div>       
        @endif

        @if($kelas->isEmpty())
            <div class="flex items-center justify-center min-h-[400px]">
                <div class="text-center p-8 bg-white rounded-xl shadow-lg">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M12 20V4"/>
                    </svg>
                    <p class="text-gray-600 text-lg">Petugas belum menambahkan kelas.</p>
                </div>
            </div>
        @else
            <div class="container mx-auto px-4">
                <h1 class="text-center lg:text-3xl sm:text-2xl text-base font-bold mb-12 text-green-800">
                    <span class="inline-block border-b-4 border-green-400 pb-2">
                        Pilih Kelas untuk Melihat Absensi Siswa
                        <span class="text-green-600 sm:text-xl text-sm block mt-1">(Sekretaris)</span>
                    </span>
                </h1>

                @foreach(['X', 'XI', 'XII'] as $grade)
                    <div class="mb-12" x-data="{ show: false }" x-show="true" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="flex justify-center mb-6">
                            <h2 class="text-base sm:text-lg font-bold text-green-700 px-6 py-2 bg-green-100 rounded-full">
                                Kelas {{ $grade }}
                            </h2>
                        </div>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                            @foreach ($kelas as $item)
                                @if (Str::startsWith(trim($item->kelas), $grade) && 
                                    ($grade !== 'XI' || !Str::startsWith(trim($item->kelas), 'XII')) && 
                                    ($grade !== 'X' || (!Str::startsWith(trim($item->kelas), 'XI') && !Str::startsWith(trim($item->kelas), 'XII'))))
                                    
                                    <a href="{{ url('absen_siswa/kelas/' . $item->slug) }}" 
                                        class="group relative overflow-hidden bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                                        <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="relative p-6 text-center">
                                            <h3 class="text-sm sm:text-xl font-semibold text-gray-800 group-hover:text-white transition-colors duration-300">
                                                {{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }}
                                            </h3>
                                            <p class="mt-2 text-green-600 sm:text-base text-xs group-hover:text-green-100 transition-colors duration-300">
                                                {{ $item->thn_ajaran }}
                                            </p>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>