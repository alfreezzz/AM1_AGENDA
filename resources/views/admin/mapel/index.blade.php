<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @if(session('status'))
            <div class="bg-gradient-to-r from-gray-700 to-gray-900 border-b border-gray-900 text-[#C7EEFF] text-center p-4 rounded-lg mb-4">
                <h1 class="text-sm font-bold tracking-wide text-center text-white transition-transform duration-300 sm:text-lg drop-shadow-lg hover:scale-105">{{ session('status') }}</h1>
            </div>
        @endif
        <!-- Search and Add Section -->
        <div class="flex flex-col items-center gap-4 mb-8 md:flex-row md:justify-between">
            <!-- Form Pencarian Mapel -->
            <form action="{{ url('mapel') }}" method="GET" 
                class="flex flex-col w-full gap-2 sm:w-auto sm:flex-row">
                <div class="relative flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari Mapel atau Guru..."
                            class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" />
                    <button type="submit" class="absolute -translate-y-1/2 right-3 top-1/2">
                        <svg class="w-5 h-5 text-gray-400 transition-colors duration-200 hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            <x-btn-add href="{{ url('mapel/create') }}">Tambah Mapel</x-btn-add>
        </div>

        @if($mapel->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-center bg-white border border-gray-100 shadow-lg rounded-xl">
                <svg class="w-16 h-16 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-lg text-gray-500">Mata pelajaran belum ditambahkan.</p>
            </div>
        @else
            <div class="bg-white border border-gray-100 shadow-lg rounded-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama Mapel</th>
                                <th class="px-4 py-3">Nama Guru</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($mapel as $item)
                            <tr class="transition duration-200 hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-center text-gray-500 whitespace-nowrap">
                                    {{ $loop->iteration + ($mapel->currentPage() - 1) * $mapel->perPage() }}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $item->nama_mapel }}</td>
                                <td class="px-4 py-3">
                                    <div x-data="{ openGuru: false }">
                                        <button @click="openGuru = !openGuru" class="flex items-center w-full px-3 py-2 text-sm text-left transition duration-200 rounded-lg bg-gray-50 hover:bg-gray-100">
                                            <span class="font-medium text-gray-700">Lihat Guru</span>
                                            <svg :class="{ 'rotate-180': openGuru }" class="w-5 h-5 ml-auto text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                            </svg>
                                        </button>
                                        <div x-show="openGuru" class="pl-2 mt-2 space-y-2">
                                            @forelse ($item->dataGurus as $guru)
                                                <span class="block bg-green-50 text-green-700 py-2.5 px-3 rounded-lg text-sm">
                                                    {{ $guru->name }}
                                                </span>
                                            @empty
                                                <span class="text-sm text-gray-400">Tidak ada guru</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <x-btn-edit href="{{ url('mapel/' . $item->id . '/edit') }}"></x-btn-edit>
                                        <x-btn-delete action="{{ url('mapel/' . $item->id) }}"></x-btn-delete>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="py-4 border-t border-gray-200">
                    {{ $mapel->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>
</x-layout>