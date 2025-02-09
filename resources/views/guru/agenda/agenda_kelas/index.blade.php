<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Action Buttons Section -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 p-4">
        @if(Auth::user()->role == 'Guru')
            <a href="{{ url('agenda/create/' . $kelas->id) }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200 mb-2 md:mb-0">
                Tambah Agenda
            </a>
        @endif

        <form id="filter-form" method="GET" action="{{ url('agenda/kelas/' . $kelas->slug) }}" class="flex items-center space-x-2">
            <select name="filter" id="filter" class="py-2 px-4 border border-gray-300 rounded focus:ring-2 focus:ring-green-500">
                <option value="">Semua Tanggal</option>
                <option value="last_week" {{ request('filter') == 'last_week' ? 'selected' : '' }}>Minggu Lalu</option>
                <option value="last_month" {{ request('filter') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                <option value="range" {{ request('filter') == 'range' ? 'selected' : '' }}>Rentang Tanggal</option>
            </select>
        
            <div id="date-range" class="hidden flex space-x-2">
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="py-2 px-4 border border-gray-300 rounded focus:ring-2 focus:ring-green-500">
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="py-2 px-4 border border-gray-300 rounded focus:ring-2 focus:ring-green-500">
            </div>
        </form>
    </div>

    @if($agenda->isEmpty())
        <p class="text-center mt-4">Tidak ada agenda untuk kelas ini.</p>
    @else
        @php
            $groupedAgendas = $agenda->groupBy('tgl');
        @endphp

        <!-- Displaying Agenda Items Grouped by Date -->
        @foreach ($groupedAgendas as $date => $agendas)
            <h2 class="text-xl font-semibold mb-2 mt-4 text-green-600">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg table-auto">
                    <thead class="sticky top-0 bg-green-500 text-white">
                        <tr class="text-center">
                            <th class="py-3 px-6">No</th>
                            @if(Auth::user()->role == 'Admin')
                            <th class="py-3 px-6">Nama Guru</th>
                            @endif
                            <th class="py-3 px-6">Mapel</th>
                            <th class="py-3 px-6">Aktivitas</th>
                            <th class="py-3 px-6">Jam Masuk</th>
                            <th class="py-3 px-6">Jam Keluar</th>
                            @if(Auth::user()->role == 'Admin')
                                <th class="py-3 px-6">Waktu Ditambahkan</th>
                            @endif
                            @if(Auth::user()->role == 'Guru')
                            <th class="py-3 px-6">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($agendas as $item)
                            <tr class="border-t border-gray-200 hover:bg-gray-100 text-center">
                                <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                @if(Auth::user()->role == 'Admin')
                                <td class="px-4 py-2">{{ $item->user->name }}</td>
                                @endif
                                <td class="py-3 px-6">{{ $item->mapel->nama_mapel }}</td>
                                <td class="py-3 px-6">{{ $item->aktivitas }}</td>
                                <td class="py-3 px-6">{{ $item->jam_msk }}</td>
                                <td class="py-3 px-6">{{ $item->jam_keluar }}</td>
                                @if(Auth::user()->role == 'Admin')
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}</td>
                                @endif
                                @if(Auth::user()->role == 'Guru')
                                <td class="px-4 py-2 text-center">
                                    <div class="flex justify-center items-center space-x-2">
                                        <a href="{{ url('agenda/' . $item->id . '/edit') }}" class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600 transition duration-200">Edit</a>
                                        <form action="{{ url('agenda/' . $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 transition duration-200">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let filter = document.getElementById('filter');
            let startDate = document.getElementById('start_date');
            let endDate = document.getElementById('end_date');
            let dateRange = document.getElementById('date-range');
            let form = document.getElementById('filter-form');
    
            // Tampilkan input rentang tanggal jika sudah dipilih sebelumnya
            if (filter.value === 'range') {
                dateRange.classList.remove('hidden');
            }
    
            // Fungsi untuk submit otomatis
            function autoSubmit() {
                form.submit();
            }
    
            // Submit otomatis saat filter berubah
            filter.addEventListener('change', function () {
                if (this.value === 'range') {
                    dateRange.classList.remove('hidden');
                } else {
                    dateRange.classList.add('hidden');
                    startDate.value = "";
                    endDate.value = "";
                    autoSubmit();
                }
            });
    
            // Submit otomatis saat tanggal rentang dipilih
            startDate.addEventListener('change', autoSubmit);
            endDate.addEventListener('change', autoSubmit);
        });
    </script>
</x-layout>
