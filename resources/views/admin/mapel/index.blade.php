<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="flex flex-col md:flex-row md:justify-between items-center mb-6 p-4 rounded-lg">
        <!-- Form Pencarian Mapel -->
        <form action="{{ url('mapel') }}" method="GET" class="flex flex-col md:flex-row md:space-x-4 w-full md:w-auto mb-4 md:mb-0">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari mapel atau guru..." class="py-2 px-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded mt-2 md:mt-0 transition duration-200">Cari</button>
        </form>

        <a href="{{ url('mapel/create') }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">Tambah Data</a>
    </div>

    @if($mapel->isEmpty())
        <p class="text-center mt-4">Mata pelajaran belum ditambahkan.</p>
    @else
        <!-- Tabel data mapel dengan desain konsisten -->
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="sticky top-0 bg-green-500 text-white">
                    <tr class="text-center">
                        <th class="py-3 px-6">Nama Mapel</th>
                        <th class="py-3 px-6">Nama Guru</th>
                        <th class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mapel as $item)
                    <tr class="border-t border-gray-200 hover:bg-gray-100 text-center transition duration-200">
                        <td class="py-3 px-6">{{ $item->nama_mapel }}</td>
                        <td class="py-3 px-6">
                            @foreach ($item->dataGurus as $guru)
                                {{ $guru->name }}{{ !$loop->last ? ',' : '' }}<br>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{ url('mapel/' . $item->id . '/edit') }}" class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600 transition duration-200">Edit</a>
                                <form action="{{ url('mapel/' . $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 transition duration-200">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>                
            </table>
        </div>
    @endif
</x-layout>
