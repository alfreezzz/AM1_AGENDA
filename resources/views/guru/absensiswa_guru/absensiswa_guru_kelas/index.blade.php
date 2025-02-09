<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Action Buttons Section -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 p-4">
        @if(Auth::user()->role == 'Guru')
            <a href="{{ url('absensiswa_guru/create/' . $kelas->id) }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200 mb-2 md:mb-0">
                Tambah Absensi Siswa
            </a>
        @endif

        <form id="filter-form" method="GET" action="{{ url('absensiswa_guru/kelas/' . $kelas->slug) }}" class="flex items-center space-x-2">
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

    @if($absensi->isEmpty())
        <p class="text-center mt-4">Tidak ada absen siswa untuk kelas ini.</p>
    @else
    @php
        $groupedAbsensi = $absensi->groupBy('tgl');
    @endphp

    @foreach ($groupedAbsensi as $date => $absensiGroup)
        <h2 class="text-xl font-semibold mb-2 mt-4 text-green-600">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h2>

        @php
            $guruGrouped = $absensiGroup->groupBy('user.name');
        @endphp

        @foreach ($guruGrouped as $guru => $guruGroup)
            @if(Auth::user()->role == 'Admin')
                <h3 class="text-lg font-medium mb-2 mt-2 text-blue-600">Guru: {{ $guru }}</h3>
            @endif

            @php
                $mapelGrouped = $guruGroup->groupBy('mapel.nama_mapel');
            @endphp

            @foreach ($mapelGrouped as $mapel => $mapelGroup)
                <h4 class="text-md font-medium mb-2 mt-2 text-gray-700">Mata Pelajaran: {{ $mapel }}</h4>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg table-auto">
                        <thead class="sticky top-0 bg-green-500 text-white">
                            <tr class="text-center">
                                <th class="py-3 px-6">No</th>
                                <th class="py-3 px-6">Nama Siswa</th>
                                <th class="py-3 px-6">Keterangan</th>
                                <th class="py-3 px-6">Waktu Ditambahkan</th>
                                @if(Auth::user()->role == 'Guru')
                                    <th class="py-3 px-6">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mapelGroup as $item)
                                <tr class="border-t border-gray-200 hover:bg-gray-100 text-center">
                                    <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 text-left">{{ $item->data_siswa->nama_siswa }}</td>
                                    <td class="px-4 py-2">{{ $item->keterangan }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}</td>
                                    @if(Auth::user()->role == 'Guru')
                                        <td class="px-4 py-2 text-center">
                                            <div class="flex justify-center items-center space-x-2">
                                                <a href="{{ url('absensiswa_guru/' . $item->id . '/edit') }}" class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600 transition duration-200">Edit</a>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @endforeach
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
