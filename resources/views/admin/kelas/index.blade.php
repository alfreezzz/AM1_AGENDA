<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8">
            <!-- Search Form -->
            <form action="{{ url('jurusan/' . $jurusan->id . '/kelas') }}" method="GET" 
                  class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
                <div class="relative flex-grow">
                    <input type="search" name="search" value="{{ $search }}" 
                           placeholder="Cari Tahun Ajaran"
                           class="w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-20 transition-all duration-200" />
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                        <svg class="w-5 h-5 text-gray-400 hover:text-green-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Add Class Button -->
            <a href="{{ url('kelas/create?jurusan=' . $jurusan->id) }}" 
               class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-green-500 hover:bg-green-600 text-white font-medium shadow-sm hover:shadow transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Kelas
            </a>
        </div>

        @if($kelas->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 px-4 bg-white rounded-lg shadow-sm border border-gray-100">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-gray-500 text-lg">Data kelas belum ditemukan.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun Ajaran</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Guru Pengajar</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($kelas as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-2 text-center whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }}
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $item->thn_ajaran }}</td>
                            <td class="px-4 py-2">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" 
                                            class="inline-flex items-center px-3 py-1.5 rounded-full bg-green-50 text-green-700 text-sm font-medium hover:bg-green-100 transition-colors duration-200">
                                        <span>Lihat Guru</span>
                                        <svg :class="{ 'rotate-180': open }" class="ml-1.5 w-4 h-4 transition-transform duration-200" 
                                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform scale-95"
                                         x-transition:enter-end="opacity-100 transform scale-100"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 transform scale-100"
                                         x-transition:leave-end="opacity-0 transform scale-95"
                                         @click.away="open = false"
                                         class="absolute left-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                        <div class="py-2 px-3">
                                            @forelse ($item->dataGuruKelas as $guru)
                                                <div class="py-1.5 text-sm text-gray-700">{{ $guru->name }}</div>
                                            @empty
                                                <div class="py-1.5 text-sm text-gray-500">Tidak ada guru</div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center justify-center text-center space-x-2">
                                    <a href="{{ url('kelas/' . $item->id . '/edit') }}" 
                                       class="inline-flex items-center px-3 py-1.5 rounded-md bg-yellow-50 text-yellow-600 hover:bg-yellow-100 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ url('kelas/' . $item->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 rounded-md bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
        @endif
    </div>
</x-layout>