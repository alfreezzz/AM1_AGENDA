<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="flex flex-col md:flex-row md:justify-between items-center mb-6 p-4 rounded-lg">
        <!-- Form Pencarian -->
        <form action="{{ url('user') }}" method="GET" id="filterForm" class="flex flex-col md:flex-row md:space-x-4 w-full md:w-auto mb-4 md:mb-0">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari username..." class="py-2 px-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
            <select name="filterRole" id="filterRole" onchange="document.getElementById('filterForm').submit();" class="py-2 px-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 mt-2 md:mt-0">
                <option value="">Role</option>
                <option value="Admin" {{ request('filterRole') == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Guru" {{ request('filterRole') == 'Guru' ? 'selected' : '' }}>Guru</option>
                <option value="Sekretaris" {{ request('filterRole') == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
            </select>
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded mt-2 md:mt-0 transition duration-200">Cari</button>
        </form>
        <a href="{{ url('user/create') }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">Tambah Data</a>
    </div>

    @if($user->isEmpty())
        <p class="text-center mt-4">Data pengguna belum ditambahkan.</p>
    @else

    <!-- Tabel data pengguna dengan scroll hanya untuk desktop -->
    <div class="overflow-x-auto mt-4">
        <div class="max-h-96 md:overflow-y-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="sticky top-0 bg-green-500 text-white">
                    <tr class="text-center">
                        <th class="py-3 px-6">No</th>
                        <th class="py-3 px-6">Username</th>
                        <th class="py-3 px-6">Role</th>
                        <th class="py-3 px-6">Mapel & Kelas Mengajar</th>
                        <th class="py-3 px-6">Kelas</th>
                        <th class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $item)
                    <tr class="border-t border-gray-200 hover:bg-gray-100 text-center transition duration-200">
                        <td class="py-3 px-6">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6 text-left">{{ $item->name }}</td>
                        <td class="py-3 px-6">{{ $item->role }}</td>
                        <td class="py-3 px-6">
                            @forelse ($item['mapels'] as $mapel)
                                {{ $mapel['nama_mapel'] }}{{ !$loop->last ? ',' : '' }}<br>
                            @empty
                                -
                            @endforelse
                            <hr class="border-t-2 border-green-300">
                            @forelse ($item['dataKelas'] as $kelas)
                                {{ $kelas['kelas'] }} {{ $kelas->jurusan->jurusan_id }} {{ $kelas->kelas_id }} ({{ $kelas->thn_ajaran }}) {{ !$loop->last ? ',' : '' }}<br>
                            @empty
                                -
                            @endforelse
                        </td>                        
                        <td class="py-3 px-6">
                            @if($item->kelas)
                                {{ $item->kelas->kelas }} {{ $item->kelas->jurusan->jurusan_id }} {{ $item->kelas->kelas_id }} ({{ $item->kelas->thn_ajaran }})
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{ url('user/' . $item['id'] . '/edit') }}" class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600 transition duration-200">Edit</a>
                                <form action="{{ url('user/' . $item['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
    </div>
    @endif
</x-layout>
