<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <!-- Search, Date Filter, and Add Button aligned -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 p-4 space-y-4 md:space-y-0 md:space-x-4">
        <form id="filter-form" method="GET" action="{{ url('absen_siswa/kelas/' . $kelas->slug) }}" class="flex items-center space-x-2">
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
        @if (Auth::user()->role == 'Sekretaris')
            <a href="{{ route('absen_siswa.create') }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200 w-full md:w-auto text-center">Tambah Absensi</a>
        @endif
    </div>

    @if($absen_siswa->isEmpty())
        @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Guru')
            <p class="text-center mt-4">Tidak ada data absensi yang ditemukan</p>
        @endif
        @if (Auth::user()->role == 'Sekretaris')
            <p class="text-center mt-4">Tidak ada absensi untuk kelas ini.</p>
        @endif
    @else
        <!-- Loop through each date group -->
        @foreach ($absen_siswa as $date => $records)
            <div class="mt-4">
                <h3 class="font-bold text-lg text-green-600">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h3>
                
                <div class="overflow-y-auto max-h-80 mt-2">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg table-auto">
                        <thead class="bg-green-500 text-white">
                            <tr class="text-center">
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Nama Siswa</th>
                                <th class="px-4 py-2">Keterangan</th>
                                @if(Auth::user()->role == 'Admin')
                                    <th class="py-3 px-6">Waktu Ditambahkan</th>
                                    <th class="px-4 py-2">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $item)
                                <tr class="text-center border-t border-gray-200 hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 text-left">{{ $item->data_siswa->nama_siswa }}</td>
                                    <td class="px-4 py-2">{{ $item->keterangan }}</td>
                                    @if(Auth::user()->role == 'Admin')
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('absen_siswa.edit', $item->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition duration-200">Edit</a>
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
