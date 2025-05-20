<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8" x-data="{ 
        showDateRange: {{ request('filter') === 'range' ? 'true' : 'false' }},
        currentFilter: '{{ request('filter') }}',
        startDate: '{{ request('start_date') }}',
        endDate: '{{ request('end_date') }}'
    }">
    @if(session('status'))
            <div class="bg-gradient-to-r from-gray-700 to-gray-900 border-b border-gray-900 text-[#C7EEFF] text-center p-4 rounded-lg mb-4">
                <h1 class="text-sm sm:text-lg font-bold tracking-wide text-white text-center drop-shadow-lg hover:scale-105 transition-transform duration-300">{{ session('status') }}</h1>
            </div>
        @endif
        <!-- Action Buttons Section -->
        <div class="space-y-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-stretch gap-4">
                @if(Auth::user()->role == 'Guru')
                 <x-btn-add  href="{{ url('absensiswa_guru/create/' . $kelas->id) }}" >Tambah Absensi</x-btn-add>
                @endif
            
                <form id="filter-form" method="GET" action="{{ url('absensiswa_guru/kelas/' . $kelas->slug) }}" 
                      class="flex flex-wrap items-center gap-3">
                    <select name="filter" id="filter" x-model="currentFilter" @change="handleFilterChange()"
                            class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                        <option value="">Semua Tanggal</option>
                        <option value="last_week">Minggu Lalu</option>
                        <option value="last_month">Bulan Lalu</option>
                        <option value="range">Rentang Tanggal</option>
                    </select>
            
                    <div x-show="showDateRange" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="flex flex-wrap gap-3">
                        <input type="date" name="start_date" x-model="startDate" @change="submitForm()"
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                        <input type="date" name="end_date" x-model="endDate" @change="submitForm()"
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                    </div>
                </form>
            </div>

            <div class="flex flex-col sm:flex-row justify-between gap-4">
                <a href="{{ route('absensiswa_guru.export', ['kelas_slug' => $kelas->slug, 'filter' => request('filter'), 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                   class="inline-flex items-center justify-center bg-blue-500 text-white py-2.5 px-4 rounded-lg hover:bg-blue-600 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export Excel
                </a>
            
                <a href="{{ url('absensiswa_guru/kelas/' . $kelas->slug . '/rekapan') }}" 
                   class="inline-flex items-center justify-center bg-green-500 text-white py-2.5 px-4 rounded-lg hover:bg-green-600 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Lihat Rekapan
                </a>
            </div>
        </div>

        @if($absensi->isEmpty())
            <div class="flex items-center justify-center min-h-[200px] bg-white rounded-xl shadow-md">
                <div class="text-center p-8">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                    <p class="text-gray-600 text-lg">Tidak ada absen siswa untuk kelas ini.</p>
                </div>
            </div>
        @else
            @php
                $groupedAbsensi = $absensi->groupBy('tgl');
            @endphp

            <div class="space-y-8">
                @foreach ($groupedAbsensi as $date => $absensiGroup)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="bg-green-500 px-4 py-2">
                            <h2 class="text-xl font-semibold text-white">
                                {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                            </h2>
                        </div>

                        @php
                            $guruGrouped = $absensiGroup->groupBy('user.name');
                        @endphp

                        <div class="p-6 space-y-6">
                            @foreach ($guruGrouped as $guru => $guruGroup)
                                @if(Auth::user()->role == 'Admin')
                                    <div class="flex items-center space-x-2 text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <h3 class="text-lg font-medium">{{ $guru }}</h3>
                                    </div>
                                @endif

                                @php
                                    $mapelGrouped = $guruGroup->groupBy('mapel.nama_mapel');
                                @endphp

                                @foreach ($mapelGrouped as $mapel => $mapelGroup)
                                    <div class="space-y-4">
                                        <div class="flex items-center space-x-2 text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                            <h4 class="font-medium">{{ $mapel }}</h4>
                                        </div>

                                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr class="text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        <th class="px-4 py-2">No</th>
                                                        <th class="px-4 py-2">Nama Siswa</th>
                                                        <th class="px-4 py-2">Keterangan</th>
                                                        <th class="px-4 py-2">Surat Sakit</th>
                                                        <th class="px-4 py-2">Waktu Ditambahkan</th>
                                                        @if(Auth::user()->role == 'Guru')
                                                            <th class="px-4 py-2">Aksi</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach ($mapelGroup as $item)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-center">{{ $loop->iteration }}</td>
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
                                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-center">
                                                                {{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}
                                                            </td>
                                                            @if(Auth::user()->role == 'Guru')
                                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-center text-gray-500">
                                                                   <x-btn-edit href="{{ url('absensiswa_guru/' . $item->id . '/edit') }}" ></x-btn-edit>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        function handleFilterChange() {
            if (this.currentFilter === 'range') {
                this.showDateRange = true;
            } else {
                this.showDateRange = false;
                this.startDate = '';
                this.endDate = '';
                document.getElementById('filter-form').submit();
            }
        }

        function submitForm() {
            document.getElementById('filter-form').submit();
        }
    </script>
</x-layout>