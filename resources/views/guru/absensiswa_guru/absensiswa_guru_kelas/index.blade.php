<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8" x-data="{ 
        showDateRange: {{ request('filter') === 'range' ? 'true' : 'false' }},
        currentFilter: '{{ request('filter') }}',
        startDate: '{{ request('start_date') }}',
        endDate: '{{ request('end_date') }}'
    }">
        <!-- Action Buttons Section -->
        <div class="space-y-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-stretch gap-4">
                @if(Auth::user()->role == 'Guru')
                    <a href="{{ url('absensiswa_guru/create/' . $kelas->id) }}" 
                       class="inline-flex items-center justify-center bg-green-500 text-white py-2.5 px-4 rounded-lg hover:bg-green-600 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Absensi Siswa
                    </a>
                @endif
            
                <form id="filter-form" method="GET" action="{{ url('absensiswa_guru/kelas/' . $kelas->slug) }}" 
                      class="flex flex-wrap items-center gap-3">
                    <select name="filter" id="filter" x-model="currentFilter" @change="handleFilterChange()"
                            class="py-2.5 px-4 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 shadow-sm">
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
                               class="py-2.5 px-4 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 shadow-sm">
                        <input type="date" name="end_date" x-model="endDate" @change="submitForm()"
                               class="py-2.5 px-4 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 shadow-sm">
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
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M12 20V4"/>
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
                        <div class="bg-green-500 px-4 py-4">
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
                                                        <th class="px-4 py-2">Waktu Ditambahkan</th>
                                                        @if(Auth::user()->role == 'Guru')
                                                            <th class="px-4 py-2">Aksi</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach ($mapelGroup as $item)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $loop->iteration }}</td>
                                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->data_siswa->nama_siswa }}</td>
                                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $item->keterangan }}</td>
                                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                                {{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}
                                                            </td>
                                                            @if(Auth::user()->role == 'Guru')
                                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                                                    <a href="{{ url('absensiswa_guru/' . $item->id . '/edit') }}" 
                                                                       class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-colors duration-200">
                                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                        </svg>
                                                                        Edit
                                                                    </a>
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