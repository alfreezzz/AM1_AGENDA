<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8" x-data="{ 
        showDateRange: {{ request('filter') === 'range' ? 'true' : 'false' }},
        currentFilter: '{{ request('filter') }}',
        startDate: '{{ request('start_date') }}',
        endDate: '{{ request('end_date') }}'
    }">
        <!-- Header Section with improved spacing and shadow -->
        <div class="mb-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <!-- Action Button -->
                @if(Auth::user()->role == 'Guru')
                    <a href="{{ url('absen_guru/create/' . $kelas->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Absensi
                    </a>
                @endif

                <!-- Enhanced Filter Form -->
                <form id="filter-form" method="GET" action="{{ url('absen_guru/kelas/' . $kelas->slug) }}" 
                      class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <div class="relative">
                        <select name="filter" x-model="currentFilter"
                                class="appearance-none bg-white border border-gray-300 rounded-md pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-700 text-sm">
                            <option value="">Semua Tanggal</option>
                            <option value="last_week">Minggu Lalu</option>
                            <option value="last_month">Bulan Lalu</option>
                            <option value="range">Rentang Tanggal</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Date Range Inputs with smooth transition -->
                    <div x-show="currentFilter === 'range'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="flex space-x-4">
                        <input type="date" name="start_date" x-model="startDate"
                               class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                        <input type="date" name="end_date" x-model="endDate"
                               class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    </div>
                </form>
            </div>
        </div>

        <!-- No Data Message -->
        @if($absen_guru->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="mt-4 text-gray-600">Tidak ada absensi untuk kelas ini.</p>
            </div>
        @else
            @php
                $groupedAbsensi = $absen_guru->groupBy('tgl');
            @endphp

            <!-- Attendance Records Section -->
            @foreach ($groupedAbsensi as $date => $absensiItems)
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-green-600 px-4 py-4">
                        <h2 class="text-xl font-semibold text-white">
                            {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    @if(Auth::user()->role == 'Admin')
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Guru</th>
                                    @endif
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Mapel</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Indikator Kompetensi</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan Tugas</th>
                                    @if(Auth::user()->role == 'Admin')
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Ditambahkan</th>
                                    @endif
                                    @if(Auth::user()->role == 'Guru')
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($absensiItems as $item)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-900">{{ $loop->iteration }}</td>
                                        @if(Auth::user()->role == 'Admin')
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->user->name }}</td>
                                        @endif
                                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-900">{{ $item->mapel->nama_mapel }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-900">{{ $item->keterangan }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            @php
                                                $tugasList = json_decode($item->tugas);
                                            @endphp
                                            
                                            @if(!empty($tugasList) && is_array($tugasList))
                                                <div class="space-y-2">
                                                    @foreach ($tugasList as $file)
                                                        <a href="{{ asset('storage/' . $file) }}" 
                                                           class="flex items-center text-green-600 hover:text-green-700 group">
                                                            <svg class="w-4 h-4 mr-2 group-hover:text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                            </svg>
                                                            <span class="text-sm">{{ \Illuminate\Support\Str::limit(basename($file), 20) }}</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-900">{{ $item->keterangantugas }}</td>
                                        @if(Auth::user()->role == 'Admin')
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}
                                            </td>
                                        @endif
                                        @if(Auth::user()->role == 'Guru')
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex space-x-2">
                                                    <a href="{{ url('absen_guru/' . $item->id . '/edit') }}" 
                                                       class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md transition-colors duration-150">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                        Edit
                                                    </a>
                                                    <form action="{{ url('absen_guru/' . $item->id) }}" method="POST" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md transition-colors duration-150">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('filterData', () => ({
                init() {
                    this.$watch('currentFilter', value => {
                        if (value !== 'range') {
                            this.$refs.filterForm.submit();
                        }
                    });

                    this.$watch('startDate', value => {
                        if (this.currentFilter === 'range' && this.endDate) {
                            this.$refs.filterForm.submit();
                        }
                    });

                    this.$watch('endDate', value => {
                        if (this.currentFilter === 'range' && this.startDate) {
                            this.$refs.filterForm.submit();
                        }
                    });
                }
            }));
        });
    </script>
</x-layout>