<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <form method="GET" action="{{ url('absen_guru/kelas/' . $kelas->slug) }}" class="flex items-center space-x-2">
    <select name="filter" id="filter" class="py-2 px-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
        <option value="" selected disabled>Pilih Filter</option>
        <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
        <option value="last_week" {{ request('filter') == 'last_week' ? 'selected' : '' }}>Minggu Lalu</option>
        <option value="last_month" {{ request('filter') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
        <option value="custom" {{ request('filter') == 'custom' ? 'selected' : '' }}>Rentang Tanggal</option>
    </select>

    <input type="date" name="start_date" value="{{ request('start_date') }}" class="py-2 px-4 border border-gray-300 rounded">
    <input type="date" name="end_date" value="{{ request('end_date') }}" class="py-2 px-4 border border-gray-300 rounded">
    
    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">Filter</button>
    <a href="{{ url('absen_guru/kelas/' . $kelas->slug) }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition duration-200">Reset</a>
</form>

        <!-- Displaying Attendance Records Grouped by Date -->
        @foreach ($groupedAbsensi as $date => $absensiItems)
            <h2 class="text-xl font-semibold mb-2 mt-4 text-green-600">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h2>

            <div class="overflow-y-auto max-h-80">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg table-auto">
                    <thead class="sticky top-0 bg-green-500 text-white">
                        <tr class="text-center">
                            <th class="px-4 py-2">No</th>
                            @if(Auth::user()->role == 'Admin')
                            <th class="py-3 px-6">Nama Guru</th>
                            @endif
                            <th class="px-4 py-2">Mapel</th>
                            <th class="px-4 py-2">Keterangan</th>
                            <th class="px-4 py-2">Indikator Kompetensi</th>
                            <th class="px-4 py-2">Keterangan Tugas</th>
                            @if(Auth::user()->role == 'Admin')
                            <th class="px-4 py-2">Waktu Ditambahkan</th>
                            @endif
                            @if(Auth::user()->role == 'Guru')
                            <th class="px-4 py-2">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensiItems as $item)
                            <tr class="text-center border-t border-gray-200 hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                @if(Auth::user()->role == 'Admin')
                                <td class="px-4 py-2">{{ $item->user->name }}</td>
                                @endif
                                <td class="px-4 py-2">{{ $item->mapel->nama_mapel }}</td>
                                <td class="px-4 py-2">{{ $item->keterangan }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $tugasList = json_decode($item->tugas);
                                    @endphp
                                
                                    @if(!empty($tugasList) && is_array($tugasList))
                                        <div class="flex flex-col space-y-1">
                                            @foreach ($tugasList as $file)
                                                <a href="{{ asset('storage/' . $file) }}" download class="text-blue-500 hover:underline flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm4 8h8m-8 4h8M4 4h16v16H4V4z" />
                                                    </svg>
                                                    {{ \Illuminate\Support\Str::limit(basename($file), 20) }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="block text-gray-500">-</span>
                                    @endif
                                </td>    
                                <td class="px-4 py-2">{{ $item->keterangantugas }}</td>
                                @if(Auth::user()->role == 'Admin')
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}</td>
                                @endif
                                @if(Auth::user()->role == 'Guru')
                                <td class="px-4 py-2 text-center">
                                    <div class="flex justify-center items-center space-x-2">
                                        <a href="{{ url('absen_guru/' . $item->id . '/edit') }}" class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600 transition duration-200">Edit</a>
                                        <form action="{{ url('absen_guru/' . $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
</x-layout>
