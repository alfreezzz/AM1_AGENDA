<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8">
        @if(session('status'))
                <div class="bg-gradient-to-r from-gray-700 to-gray-900 border-b border-gray-900 text-[#C7EEFF] text-center p-4 rounded-lg mb-4">
                    <h1 class="text-sm sm:text-lg font-bold tracking-wide text-white text-center drop-shadow-lg hover:scale-105 transition-transform duration-300">{{ session('status') }}</h1>
                </div>
            @endif
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Search and Filter Form -->
                <form action="{{ url('user') }}" method="GET" id="filterForm" class="flex-1 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="relative flex-grow">
                        <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari Username..."
                                class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" />
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400 hover:text-green-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
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
                </form>

                <!-- Add User Button -->
              <x-btn-add href="{{ url('user/create') }}">Tambah Pengguna</x-btn-add>
            </div>
        </div>

        @if($user->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 fill-gray-500" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"/></svg>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="mt-4 text-lg text-gray-600">Data pengguna belum ditambahkan.</p>
            </div>
        @else
            <!-- User Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto bg-white rounded-xl shadow-xl border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="font-medium text-gray-500 uppercase tracking-wider text-center text-xs">
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Username</th>
                                <th class="px-4 py-2">Role</th>
                                <th class="px-4 py-2">Mapel & Kelas Mengajar</th>
                                <th class="px-4 py-2">Kelas</th>
                                <th class="px-4 py-2">Aksi</th>
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
                                       <x-btn-edit href="{{ url('user/' . $item['id'] . '/edit') }}" ></x-btn-edit>
                                       <x-btn-delete action="{{ url('user/' . $item['id']) }}"></x-btn-delete>
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