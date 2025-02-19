<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8">

        <!-- Search and Add Section -->
        <div class="flex flex-col md:flex-row md:justify-between items-center mb-12">
            <!-- Form Pencarian Mapel with improved styling -->
            <form action="{{ url('mapel') }}" method="GET" class="flex flex-col md:flex-row md:space-x-4 w-full md:w-auto mb-4 md:mb-0">
                <div class="relative flex-grow md:max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input 
                        type="search" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari mapel atau guru..." 
                        class="pl-10 w-full py-3 px-4 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                    >
                </div>
                <button type="submit" class="inline-flex items-center justify-center bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-lg font-medium transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>
            </form>

            <x-btn-add href="{{ url('mapel/create') }}">Tambah Mapel</x-btn-add>
        </div>

        @if($mapel->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 bg-white rounded-xl shadow-lg border border-gray-100">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-500 text-lg">Mata pelajaran belum ditambahkan.</p>
            </div>
        @else
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr class="text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                <th class="px-4 py-2">Nama Mapel</th>
                <th class="px-4 py-2">Nama Guru</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($mapel as $item)
            <tr class="hover:bg-gray-50 transition duration-200">
                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $item->nama_mapel }}
                </td>
                <td class="px-4 py-2 whitespace-nowrap">
                    <div x-data="{ openGuru: false }" class="space-y-3">
                        <div>
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
                    </div>
                </td>
                <td class="px-4 py-2 whitespace-nowrap text-center text-sm">
                    <div class="flex justify-center items-center space-x-2">
                        <x-btn-edit href="{{ url('mapel/' . $item->id . '/edit') }}"></x-btn-edit>
                        <x-btn-delete action="{{ url('mapel/' . $item->id) }}"></x-btn-delete>
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