<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <a href="{{ url('jurusan/create') }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">Tambah Data Jurusan</a>

    @if($jurusan->isEmpty())
        <p class="text-center mt-4">Data jurusan belum ditambahkan.</p>
    @else
        <div class="overflow-x-auto mt-4 mb-10">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="sticky top-0 bg-green-500 text-white">
                    <tr class="text-center">
                        <th class="py-3 px-6">No</th>
                        <th class="py-3 px-6">Nama Jurusan</th>
                        <th class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurusan as $item)
                    <tr class="border-t border-gray-200 hover:bg-gray-100 text-center transition duration-200">
                        <td class="py-3 px-6">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6">{{ $item->jurusan_id }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{ url('jurusan/' . $item->slug . '/kelas') }}" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 transition duration-200">View Kelas</a>
                                <a href="{{ url('jurusan/' . $item->id . '/edit') }}" class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600 transition duration-200">Edit</a>
                                <form action="{{ url('jurusan/' . $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
