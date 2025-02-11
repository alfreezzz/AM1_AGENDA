<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Search and Filter Form -->
                <form action="{{ url('user') }}" method="GET" id="filterForm" class="flex-1 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="relative">
                        <input type="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari username..." 
                               class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-20 transition-colors duration-200"
                        >
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                    </div>
                    
                    <select name="filterRole" 
                            id="filterRole" 
                            onchange="document.getElementById('filterForm').submit();" 
                            class="w-full py-2.5 px-4 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-20 transition-colors duration-200"
                    >
                        <option value="">Semua Role</option>
                        <option value="Admin" {{ request('filterRole') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Guru" {{ request('filterRole') == 'Guru' ? 'selected' : '' }}>Guru</option>
                        <option value="Sekretaris" {{ request('filterRole') == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                    </select>
                    
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                </form>

                <!-- Add User Button -->
                <a href="{{ url('user/create') }}" class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Data
                </a>
            </div>
        </div>

        @if($user->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="mt-4 text-lg text-gray-600">Data pengguna belum ditambahkan.</p>
            </div>
        @else
            <!-- User Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">No</th>
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider text-left">Username</th>
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Role</th>
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider text-left">Mapel & Kelas Mengajar</th>
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Kelas</th>
                                <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($user as $item)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-4 py-2 whitespace-nowrap text-center text-sm text-gray-500">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->name }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-center">
                                    <span class="px-3 py-2 text-sm rounded-full 
                                        {{ $item->role === 'Admin' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ $item->role === 'Guru' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $item->role === 'Sekretaris' ? 'bg-green-100 text-green-700' : '' }}">
                                        {{ $item->role }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <div x-data="{ openMapel: false, openKelas: false }" class="space-y-3">
                                        <div>
                                            <button @click="openMapel = !openMapel" class="w-full text-left bg-gray-50 hover:bg-gray-100 py-2 px-3 rounded-lg text-sm flex items-center transition duration-200">
                                                <span class="font-medium text-gray-700">Mapel</span>
                                                <svg :class="{ 'rotate-180': openMapel }" class="ml-auto w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                                </svg>
                                            </button>
                                            <div x-show="openMapel" class="mt-2 space-y-2 pl-2">
                                                @forelse ($item['mapels'] as $mapel)
                                                    <span class="block bg-green-50 text-green-700 py-2.5 px-3 rounded-lg text-sm">
                                                        {{ $mapel['nama_mapel'] }}
                                                    </span>
                                                @empty
                                                    <span class="text-gray-400 text-sm">Tidak ada mapel</span>
                                                @endforelse
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <button @click="openKelas = !openKelas" class="w-full text-left bg-gray-50 hover:bg-gray-100 py-2 px-3 rounded-lg text-sm flex items-center transition duration-200">
                                                <span class="font-medium text-gray-700">Kelas</span>
                                                <svg :class="{ 'rotate-180': openKelas }" class="ml-auto w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                                </svg>
                                            </button>
                                            <div x-show="openKelas" class="mt-2 space-y-2 pl-2">
                                                @forelse ($item['dataKelas'] as $kelas)
                                                    <span class="block bg-blue-50 text-blue-700 py-2.5 px-3 rounded-lg text-sm">
                                                        {{ $kelas['kelas'] }} {{ $kelas->jurusan->jurusan_id }} {{ $kelas->kelas_id }} ({{ $kelas->thn_ajaran }})
                                                    </span>
                                                @empty
                                                    <span class="text-gray-400 text-sm">Tidak ada kelas</span>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-center">
                                    @if($item->kelas)
                                        <span class="inline-flex px-3 py-2 text-sm rounded-lg bg-yellow-50 text-yellow-700">
                                            {{ $item->kelas->kelas }} {{ $item->kelas->jurusan->jurusan_id }} {{ $item->kelas->kelas_id }} ({{ $item->kelas->thn_ajaran }})
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ url('user/' . $item['id'] . '/edit') }}" 
                                           class="inline-flex items-center px-3 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition duration-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ url('user/' . $item['id']) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition duration-200">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Delete
                                            </button>
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
    </div>
</x-layout>