<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="min-h-screen pb-8">
        @if(auth()->user()->role === 'Admin')
            <div class="container flex justify-end px-4 mx-auto mb-8 space-x-4 text-xs sm:text-base">
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
                <div class="p-8 text-center bg-white shadow-lg rounded-xl">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M12 20V4"/>
                    </svg>
                    <p class="text-lg text-gray-600">Petugas belum menambahkan kelas.</p>
                </div>
            </div>
        @else
            <div class="container px-4 mx-auto">
                <h1 class="mb-12 text-base font-bold text-center text-green-800 lg:text-3xl sm:text-2xl">
                    <span class="inline-block pb-2 border-b-4 border-green-400">
                        Pilih Kelas untuk Melihat Absensi Siswa
                        <span class="block mt-1 text-sm text-green-600 sm:text-xl">(Sekretaris)</span>
                    </span>
                </h1>

                @foreach(['X', 'XI', 'XII'] as $grade)
                    <div class="mb-12" x-data="{ show: false }" x-show="true" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="flex justify-center mb-6">
                            <h2 class="px-6 py-2 text-base font-bold text-green-700 bg-green-100 rounded-full sm:text-lg">
                                Kelas {{ $grade }}
                            </h2>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6 sm:grid-cols-3">
                            @foreach ($kelas as $item)
                                @if (Str::startsWith(trim($item->kelas), $grade) && 
                                    ($grade !== 'XI' || !Str::startsWith(trim($item->kelas), 'XII')) && 
                                    ($grade !== 'X' || (!Str::startsWith(trim($item->kelas), 'XI') && !Str::startsWith(trim($item->kelas), 'XII'))))
                                    
                                    <a href="{{ url('absen_siswa/kelas/' . $item->slug) }}" 
                                        class="relative overflow-hidden transition-all duration-300 transform bg-white shadow-lg group rounded-xl hover:shadow-2xl hover:-translate-y-1">
                                        
                                        <!-- Gradient overlay untuk hover effect -->
                                        <div class="absolute inset-0 transition-opacity duration-300 opacity-0 bg-gradient-to-r from-green-600 to-green-400 group-hover:opacity-100"></div>
                                        
                                        <!-- Badge untuk Jadwal Hari Ini - posisi absolute di pojok kanan atas -->
                                        @if(auth()->user()->role === 'Guru' && $item->harus_diisi)
                                            <div class="absolute z-10 top-3 right-3">
                                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-white bg-gradient-to-r from-orange-500 to-red-500 rounded-full shadow-lg border border-white/20 animate-pulse">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Hari Ini
                                                </span>
                                            </div>
                                        @endif
                                        
                                        <div class="relative p-6 text-center">
                                            <h3 class="text-sm font-semibold text-gray-800 transition-colors duration-300 sm:text-xl group-hover:text-white">
                                                {{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }}
                                            </h3>
                                            <p class="mt-2 text-xs text-green-600 transition-colors duration-300 sm:text-base group-hover:text-green-100">
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