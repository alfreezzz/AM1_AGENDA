<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('status'))
            <div class="bg-gradient-to-r from-gray-700 to-gray-900 border-b border-gray-900 text-[#C7EEFF] text-center p-4 rounded-lg mb-4">
                <h1 class="text-sm sm:text-lg font-bold tracking-wide text-white text-center drop-shadow-lg hover:scale-105 transition-transform duration-300">{{ session('status') }}</h1>
            </div>
        @endif
        <!-- Search and Add Section -->
        <div class="flex flex-col md:flex-row md:justify-between items-center mb-8 gap-4">
            <!-- Form Pencarian Mapel -->
            <form action="{{ url('mapel') }}" method="GET" 
                class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
                <div class="relative flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari Mapel atau Guru..."
                            class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" />
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                        <svg class="w-5 h-5 text-gray-400 hover:text-green-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            <x-btn-add href="{{ url('mapel/create') }}">Tambah Mapel</x-btn-add>
        </div>

        @if($mapel->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 bg-white rounded-xl shadow-lg border border-gray-100 text-center">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-500 text-lg">Mata pelajaran belum ditambahkan.</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Mapel</th>
                            <th class="px-4 py-3">Nama Guru</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($mapel as $item)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-4 py-2 text-center whitespace-nowrap text-sm text-gray-500">
                                {{ $loop->iteration + ($mapel->currentPage() - 1) * $mapel->perPage() }}
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $item->nama_mapel }}</td>
                            <td class="px-4 py-3">
                                <div x-data="{ openGuru: false }">
                                    <button @click="openGuru = !openGuru" class="w-full text-left bg-gray-50 hover:bg-gray-100 py-2 px-3 rounded-lg text-sm flex items-center transition duration-200">
                                        <span class="font-medium text-gray-700">Lihat Guru</span>
                                        <svg :class="{ 'rotate-180': openGuru }" class="ml-auto w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                    </button>
                                    <div x-show="openGuru" class="mt-2 space-y-2 pl-2">
                                        @forelse ($item->dataGurus as $guru)
                                            <span class="block bg-green-50 text-green-700 py-2.5 px-3 rounded-lg text-sm">
                                                {{ $guru->name }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400 text-sm">Tidak ada guru</span>
                                        @endforelse
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <x-btn-edit href="{{ url('mapel/' . $item->id . '/edit') }}"></x-btn-edit>
                                    <x-btn-delete action="{{ url('mapel/' . $item->id) }}"></x-btn-delete>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="my-4 px-4">
                    {{ $mapel->links() }}
                </div>
            </div>
        @endif
    </div>
</x-layout>