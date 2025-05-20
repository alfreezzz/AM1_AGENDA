<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <div class="container mx-auto px-4 max-w-7xl" x-data="{ 
        showDateRange: {{ request('filter') === 'range' ? 'true' : 'false' }},
        startDate: '{{ request('start_date') }}',
        endDate: '{{ request('end_date') }}'
    }">
        <!-- Header Section -->
        @if(session('status'))
                <div class="bg-gradient-to-r from-gray-700 to-gray-900 border-b border-gray-900 text-[#C7EEFF] text-center p-4 rounded-lg mb-4">
                    <h1 class="text-sm sm:text-lg font-bold tracking-wide text-white text-center drop-shadow-lg hover:scale-105 transition-transform duration-300">{{ session('status') }}</h1>
                </div>
            @endif
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row justify-between items-stretch space-y-4 lg:space-y-0 lg:space-x-4">
                <!-- Filter Form -->
                <form id="filter-form" method="GET" action="{{ url('absen_siswa/kelas/' . $kelas->slug) }}" 
                      class="flex-1 flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-3">
                    <select name="filter" id="filter" 
                            x-on:change="showDateRange = $event.target.value === 'range'; if($event.target.value !== 'range') $el.form.submit()"
                            class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                        <option value="">Semua Tanggal</option>
                        <option value="last_week" {{ request('filter') == 'last_week' ? 'selected' : '' }}>Minggu Lalu</option>
                        <option value="last_month" {{ request('filter') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                        <option value="range" {{ request('filter') == 'range' ? 'selected' : '' }}>Rentang Tanggal</option>
                    </select>
                    
                    <div x-show="showDateRange" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                        <input type="date" name="start_date" x-model="startDate"
                               x-on:change="$el.form.submit()"
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                        <input type="date" name="end_date" x-model="endDate"
                               x-on:change="$el.form.submit()"
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                    </div>
                </form>

                @if (Auth::user()->role == 'Sekretaris')
                    <x-btn-add href="{{ route('absen_siswa.create') }}" >Tambah Absensi</x-btn-add>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 mb-6">
            <a href="{{ route('absen_siswa.export', ['kelas_slug' => $kelas->slug, 'filter' => request('filter'), 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
               class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Ekspor ke Excel
            </a>

            <a href="{{ url('absen_siswa/kelas/' . $kelas->slug . '/rekapan') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Lihat Rekapan
            </a>
        </div>

        <!-- Empty State -->
        @if($absen_siswa->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="mt-4 text-lg text-gray-600">
                    @if (Auth::user()->role == 'Sekretaris')
                        Tidak ada absensi untuk kelas ini.
                    @else
                        Tidak ada data absensi yang ditemukan
                    @endif
                </p>
            </div>
        @else
            <!-- Attendance Records -->
            @foreach ($absen_siswa as $date => $records)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="px-4 py-4 bg-green-500 border-b border-green-100">
                        <h3 class="text-lg font-semibold text-white">
                            {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                        </h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-4 py-2">No</th>
                                    <th class="px-4 py-2">Nama Siswa</th>
                                    <th class="px-4 py-2">Keterangan</th>
                                    <th class="px-4 py-2">Surat Sakit</th>
                                    @if(Auth::user()->role == 'Admin')
                                        <th class="px-4 py-2">Waktu Ditambahkan</th>
                                        <th class="px-4 py-2">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($records as $item)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-center text-gray-500">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->data_siswa->nama_siswa }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium
                                                {{ $item->keterangan === 'Hadir' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                                                {{ $item->keterangan === 'Izin' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : '' }}
                                                {{ $item->keterangan === 'Sakit' ? 'bg-blue-100 text-blue-800 border border-blue-200' : '' }}
                                                {{ $item->keterangan === 'Alpha' ? 'bg-red-100 text-red-800 border border-red-200' : '' }}">
                                                @if ($item->keterangan === 'Hadir')
                                                    <svg class="w-4 h-4 mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @elseif ($item->keterangan === 'Izin')
                                                    <svg class="w-4 h-4 mr-1 text-yellow-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @elseif ($item->keterangan === 'Sakit')
                                                    <svg class="w-4 h-4 mr-1 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @elseif ($item->keterangan === 'Alpha')
                                                    <svg class="w-4 h-4 mr-1 text-red-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                                {{ $item->keterangan }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($item->surat_sakit)
                                                <a href="{{ asset('storage/' . $item->surat_sakit) }}" 
                                                target="_blank"
                                                class="relative group inline-block">
                                                    <div class="overflow-hidden rounded-lg shadow-sm border border-gray-200 transition-all duration-300 group-hover:shadow-md group-hover:border-blue-300">
                                                        <img src="{{ asset('storage/' . $item->surat_sakit) }}" 
                                                            alt="Surat Sakit" 
                                                            class="h-20 w-auto object-cover transition-transform duration-300 group-hover:scale-105">
                                                    </div>
                                                    <div class="absolute inset-0 bg-blue-500 bg-opacity-0 group-hover:bg-opacity-10 flex items-center justify-center transition-all duration-300 rounded-lg">
                                                        <span class="opacity-0 group-hover:opacity-100 bg-blue-600 text-white text-xs px-2 py-1 rounded shadow transition-opacity duration-300">Lihat</span>
                                                    </div>
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-sm italic">Tidak ada dokumen</span>
                                            @endif
                                        </td>
                                        @if(Auth::user()->role == 'Admin')
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                {{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                               <x-btn-edit href="{{ route('absen_siswa.edit', $item->id) }}" ></x-btn-edit>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</x-layout>