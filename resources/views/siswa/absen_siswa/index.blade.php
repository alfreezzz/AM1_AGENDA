<!-- resources/views/absen_siswa/index.blade.php -->
<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Container Section -->
    <div class="container mx-auto px-4 py-4 bg-white rounded-lg shadow-lg">
        
        <!-- Search, Date Filter, and Add Button aligned -->
        <div class="flex flex-col md:flex-row justify-between mb-6">
            <form method="GET" action="{{ route('absen_siswa.index') }}" class="flex flex-col md:flex-row items-center w-full md:w-auto mb-4 md:mb-0">
                <input type="text" name="search" placeholder="Cari siswa..." value="{{ $search ?? '' }}" class="border rounded p-2 mr-2 w-full md:w-64 mb-2 md:mb-0">
                
                <input type="date" name="date" value="{{ $filterDate ?? '' }}" class="border rounded p-2 mr-2">
                
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">Cari</button>
                <a href="{{ route('absen_siswa.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 ml-2">Reset</a>
            </form>

            <a href="{{ route('absen_siswa.create') }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Tambah absensi</a>
        </div>

        @if(isset($searchMessage))
            <p class="text-center mt-4">{{ $searchMessage }}</p>
        @elseif($absen_siswa->isEmpty())
            <p class="text-center mt-4">Tidak ada absensi untuk kelas ini.</p>
        @else
            <!-- Loop through each date group -->
            @foreach ($absen_siswa as $date => $records)
                <div class="mt-4">
                    <h3 class="font-bold text-lg text-green-600">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h3>
                    
                    <div class="overflow-y-auto max-h-80 mt-2">
                        <table class="min-w-full bg-white border-collapse border border-gray-300 rounded-lg table-auto">
                            <thead>
                                <tr class="bg-green-500 text-white">
                                    <th class="px-4 py-2">No</th>
                                    <th class="px-4 py-2">Nama Siswa</th>
                                    <th class="px-4 py-2">Keterangan</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $item)
                                    <tr class="text-center border-t">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 text-left">{{ $item->data_siswa->nama_siswa }}</td>
                                        <td class="px-4 py-2">{{ $item->keterangan }}</td>
                                        <td class="px-4 py-2">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('absen_siswa.edit', $item->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600">Edit</a>
                                                <form action="{{ route('absen_siswa.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</x-layout>
