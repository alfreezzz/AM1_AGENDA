<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Action Buttons Section -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 p-4">
        @if(Auth::user()->role == 'Guru')
            <a href="{{ url('absen_guru/create/' . $kelas->id) }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200 mb-2 md:mb-0">
                Tambah Absensi
            </a>
        @endif

        <!-- Date Filter Form -->
        <form method="GET" action="{{ url('absen_guru/kelas/' . $kelas->id) }}" class="flex items-center space-x-2">
            <input type="date" id="date" name="date" value="{{ $filterDate ?? '' }}" class="py-2 px-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">Filter
            </button>
            <a href="{{ url('absen_guru/kelas/' . $kelas->id) }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition duration-200">Reset</a>
        </form>
    </div>

    @if($absen_guru->isEmpty())
        <p class="text-center mt-4">Tidak ada absensi untuk kelas ini.</p>
    @else
        @php
            $groupedAbsensi = $absen_guru->groupBy('tgl');
        @endphp

        <!-- Displaying Attendance Records Grouped by Date -->
        @foreach ($groupedAbsensi as $date => $absensiItems)
            <h2 class="text-xl font-semibold mb-2 mt-4 text-green-600">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h2>

            <div class="overflow-y-auto max-h-80">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg table-auto">
                    <thead class="sticky top-0 bg-green-500 text-white">
                        <tr class="text-center">
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Guru</th>
                            <th class="px-4 py-2">Mapel</th>
                            <th class="px-4 py-2">Keterangan</th>
                            <th class="px-4 py-2">Indikator Kompetensi</th>
                            @if(Auth::user()->role == 'Guru')
                            <th class="px-4 py-2">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensiItems as $item)
                            <tr class="text-center border-t border-gray-200 hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 text-left">{{ $item->mapel->data_guru->nama_guru ?? 'Guru tidak ditemukan' }}</td>
                                <td class="px-4 py-2">{{ $item->mapel->nama_mapel }}</td>
                                <td class="px-4 py-2">{{ $item->keterangan }}</td>
                                <td class="px-4 py-2">
                                    @if($item->tugas)
                                        <div class="flex flex-col space-y-1">
                                            @foreach (json_decode($item->tugas) as $file)
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
                                @if(Auth::user()->role == 'Guru')
                                <td class="px-4 py-2 text-center">
                                    <div class="flex justify-center items-center space-x-2">
                                        <a href="{{ url('absen_guru/' . $item->id . '/edit') }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition duration-200">Edit</a>
                                        <form action="{{ url('absen_guru/' . $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-200">Delete</button>
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
