<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8">

        <!-- Search and Add Section -->
        <div class="flex flex-col md:flex-row md:justify-between items-center mb-6 p-6 rounded-xl bg-white shadow-lg border border-gray-100">
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

            <a href="{{ url('mapel/create') }}" class="inline-flex items-center justify-center bg-green-500 text-white py-3 px-4 rounded-lg hover:bg-green-600 transition duration-200 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Data
            </a>
        </div>

        @if($mapel->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 bg-white rounded-xl shadow-lg border border-gray-100">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-500 text-lg">Mata pelajaran belum ditambahkan.</p>
            </div>
        @else
            <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="text-center">
                            <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mapel</th>
                            <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Guru</th>
                            <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($mapel as $item)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->nama_mapel }}
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div x-data="{ open: false }" class="relative">
                                    <button 
                                        @click="open = !open" 
                                        class="w-full text-left bg-gray-50 hover:bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm flex items-center transition duration-200"
                                    >
                                        <span class="mr-2">Lihat Guru</span>
                                        <svg 
                                            :class="{ 'rotate-180': open }" 
                                            class="ml-auto w-5 h-5 transition-transform duration-300" 
                                            xmlns="http://www.w3.org/2000/svg" 
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke="currentColor"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                    <div 
                                        x-show="open" 
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform scale-95"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-95"
                                        class="absolute left-0 mt-2 w-full z-10 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                                        @click.away="open = false"
                                    >
                                        <div class="p-2 space-y-1">
                                            @forelse ($item->dataGurus as $guru)
                                                <div class="px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-50">
                                                    {{ $guru->name }}
                                                </div>
                                            @empty
                                                <div class="px-3 py-2 text-sm text-gray-500">
                                                    Tidak ada guru
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-center text-sm">
                                <div class="flex justify-center items-center space-x-2">
                                    <a 
                                        href="{{ url('mapel/' . $item->id . '/edit') }}" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form 
                                        action="{{ url('mapel/' . $item->id) }}" 
                                        method="POST" 
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200"
                                        >
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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