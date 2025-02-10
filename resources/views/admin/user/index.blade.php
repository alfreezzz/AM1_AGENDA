<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="flex flex-col md:flex-row md:justify-between items-center mb-6 rounded-lg">
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

    <!-- Tabel data pengguna -->
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead class="sticky top-0 bg-green-500 text-white">
                <tr>
                    <th class="py-3 px-6 text-center">No</th>
                    <th class="py-3 px-6 text-left">Username</th>
                    <th class="py-3 px-6 text-center">Role</th>
                    <th class="py-3 px-6 text-left">Mapel & Kelas Mengajar</th>
                    <th class="py-3 px-6 text-center">Kelas</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $item)
                <tr class="border-t border-gray-200 hover:bg-gray-100 transition duration-200">
                    <td class="py-3 px-6 text-center">{{ $loop->iteration }}</td>
                    <td class="py-3 px-6">{{ $item->name }}</td>
                    <td class="py-3 px-6 text-center">{{ $item->role }}</td>
                    <td class="py-3 px-6">
                        <div x-data="{ openMapel: false, openKelas: false }" class="space-y-2">
                            <div>
                                <button @click="openMapel = !openMapel" class="w-full text-left bg-green-100 text-green-700 py-1 px-2 rounded text-sm flex items-center">
                                    Mapel
                                    <svg :class="{ 'rotate-180': openMapel }" class="ml-auto w-5 h-5 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                                <div x-show="openMapel" class="space-y-2 mt-2">
                                    @forelse ($item['mapels'] as $mapel)
                                        <span class="block bg-green-100 text-green-700 py-1 px-2 rounded text-sm">{{ $mapel['nama_mapel'] }}</span>
                                    @empty
                                        <span class="text-gray-500">-</span>
                                    @endforelse
                                </div>
                            </div>
                            <div>
                                <button @click="openKelas = !openKelas" class="w-full text-left bg-blue-100 text-blue-700 py-1 px-2 rounded text-sm flex items-center">
                                    Kelas
                                    <svg :class="{ 'rotate-180': openKelas }" class="ml-auto w-5 h-5 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                                <div x-show="openKelas" class="space-y-2 mt-2">
                                    @forelse ($item['dataKelas'] as $kelas)
                                        <span class="block bg-blue-100 text-blue-700 py-1 px-2 rounded text-sm">{{ $kelas['kelas'] }} {{ $kelas->jurusan->jurusan_id }} {{ $kelas->kelas_id }} ({{ $kelas->thn_ajaran }})</span>
                                    @empty
                                        <span class="text-gray-500">-</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-center">
                        @if($item->kelas)
                            <span class="block bg-yellow-100 text-yellow-700 py-1 px-2 rounded text-sm">{{ $item->kelas->kelas }} {{ $item->kelas->jurusan->jurusan_id }} {{ $item->kelas->kelas_id }} ({{ $item->kelas->thn_ajaran }})</span>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center space-x-2">
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
    @endif
</x-layout>