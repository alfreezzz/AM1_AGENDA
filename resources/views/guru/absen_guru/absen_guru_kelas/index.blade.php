<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8" 
         x-data="{ 
            showDateRange: '{{ request('filter') }}' === 'range',
            currentFilter: '{{ request('filter') }}',
            startDate: '{{ request('start_date') }}',
            endDate: '{{ request('end_date') }}',
            
            init() {
                this.$watch('currentFilter', (value) => {
                    if (value !== 'range') {
                        this.$el.querySelector('#filter-form').submit();
                    }
                });
                
                this.$watch('startDate', (value) => {
                    if (this.currentFilter === 'range' && this.endDate && value) {
                        this.$el.querySelector('#filter-form').submit();
                    }
                });
                
                this.$watch('endDate', (value) => {
                    if (this.currentFilter === 'range' && this.startDate && value) {
                        this.$el.querySelector('#filter-form').submit();
                    }
                });
            }
         }">
        
        <!-- Rest of your existing header content -->
        
        <!-- Modified Filter Form -->
        <div class="mb-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                @if(Auth::user()->role == 'Guru')
                    <x-btn-add href="{{ url('absen_guru/create/' . $kelas->id) }}">Tambah Absensi</x-btn-add>
                @endif

                <form id="filter-form" method="GET" action="{{ url('absen_guru/kelas/' . $kelas->slug) }}" 
                      class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <div class="relative">
                        <select name="filter" 
                                x-model="currentFilter"
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                            <option value="">Semua Tanggal</option>
                            <option value="last_week">Minggu Lalu</option>
                            <option value="last_month">Bulan Lalu</option>
                            <option value="range">Rentang Tanggal</option>
                        </select>
                    </div>

                    <div x-show="currentFilter === 'range'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="flex space-x-4">
                        <input type="date" 
                               name="start_date" 
                               x-model="startDate"
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                        <input type="date" 
                               name="end_date" 
                               x-model="endDate"
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
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
                                    <th class="px-4 borderpy-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
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
                                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                                {{ $item->keterangan === 'Izin' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $item->keterangan === 'Sakit' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                {{ $item->keterangan }}
                                            </span>
                                        </td>
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
                                                   <x-btn-edit href="{{ url('absen_guru/' . $item->id . '/edit') }}" ></x-btn-edit>
                                                   <!-- <x-btn-delete action="{{ url('absen_guru/' . $item->id) }}"></x-btn-delete> -->
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