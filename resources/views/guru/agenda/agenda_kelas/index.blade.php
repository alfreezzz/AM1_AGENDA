<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <!-- Action Button -->
                @if(Auth::user()->role == 'Guru')
                    <x-btn-add href="{{ url('agenda/create/' . $kelas->id) }}" >Tambah Agenda</x-btn-add>
                @endif

                <!-- Filter Section -->
                <div x-data="{ showDateRange: '{{ request('filter') }}' === 'range' }" 
                     class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                    <form id="filter-form" method="GET" action="{{ url('agenda/kelas/' . $kelas->slug) }}" 
                          class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                        <select name="filter" id="filter" 
                                x-on:change="showDateRange = $event.target.value === 'range'; if($event.target.value !== 'range') $event.target.form.submit()"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            <option value="">Semua Tanggal</option>
                            <option value="last_week" {{ request('filter') == 'last_week' ? 'selected' : '' }}>Minggu Lalu</option>
                            <option value="last_month" {{ request('filter') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                            <option value="range" {{ request('filter') == 'range' ? 'selected' : '' }}>Rentang Tanggal</option>
                        </select>

                        <div x-show="showDateRange" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             class="flex flex-col sm:flex-row gap-4">
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                   class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                   class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        @if($agenda->isEmpty())
            <div class="text-center py-12 bg-white rounded-lg shadow-sm">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada agenda</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada agenda yang ditambahkan untuk kelas ini.</p>
            </div>
        @else
            @php
                $groupedAgendas = $agenda->groupBy('tgl');
            @endphp

            <div class="space-y-6">
                @foreach ($groupedAgendas as $date => $agendas)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-green-600 px-4 py-2">
                            <h2 class="text-lg font-semibold text-white">
                                {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                            </h2>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        @if(Auth::user()->role == 'Admin')
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Guru</th>
                                        @endif
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Mapel</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Keluar</th>
                                        @if(Auth::user()->role == 'Admin')
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Ditambahkan</th>
                                        @endif
                                        @if(Auth::user()->role == 'Guru')
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($agendas as $item)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                                            <td class="px-4 py-2 whitespace-nowrap text-center text-sm text-gray-900">{{ $loop->iteration }}</td>
                                            @if(Auth::user()->role == 'Admin')
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $item->user->name }}</td>
                                            @endif
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $item->mapel->nama_mapel }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $item->aktivitas }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-center text-sm text-gray-900">{{ $item->jam_msk }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-center text-sm text-gray-900">{{ $item->jam_keluar }}</td>
                                            @if(Auth::user()->role == 'Admin')
                                                <td class="px-4 py-2 whitespace-nowrap text-center text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}
                                                </td>
                                            @endif
                                            @if(Auth::user()->role == 'Guru')
                                                <td class="px-4 py-2 text-center whitespace-nowrap text-sm text-gray-900">
                                                    <div class="flex items-center justify-center space-x-2">
                                                      <x-btn-edit href="{{ url('agenda/' . $item->id . '/edit') }}" ></x-btn-edit>
                                                        <x-btn-delete action="{{ url('agenda/' . $item->id) }}" ></x-btn-delete>
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
            </div>
        @endif
    </div>
</x-layout>