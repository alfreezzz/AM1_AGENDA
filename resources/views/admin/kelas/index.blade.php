<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8">
        @if(session('status'))
                <div class="bg-gradient-to-r from-gray-700 to-gray-900 border-b border-gray-900 text-[#C7EEFF] text-center p-4 rounded-lg mb-4">
                    <h1 class="text-sm sm:text-lg font-bold tracking-wide text-white text-center drop-shadow-lg hover:scale-105 transition-transform duration-300">{{ session('status') }}</h1>
                </div>
            @endif
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8">
            <form action="{{ url('jurusan/' . $jurusan->slug . '/kelas') }}" method="GET" 
                class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
                <div class="relative flex-grow">
                    <input type="text" name="search" value="{{ $search }}" 
                            placeholder="Cari Tahun Ajaran..."
                            class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" />
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                        <svg class="w-5 h-5 text-gray-400 hover:text-green-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>
            <x-btn-add href="{{ url('kelas/create?jurusan=' . $jurusan->id) }}">Tambah Kelas</x-btn-add>
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
            <tr class="text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Kelas</th>
                <th class="px-4 py-2">Tahun Ajaran</th>
                <th class="px-4 py-2">Guru Pengajar</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($kelas as $item)
            <tr class="hover:bg-gray-50 transition-colors duration-200">
                <td class="px-4 py-2 text-center whitespace-nowrap text-sm text-gray-500">
                    {{ $loop->iteration }}
                </td>
                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }}
                </td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-center">
                    {{ $item->thn_ajaran }}
                </td>
                <td class="px-4 py-2">
                    <div x-data="{ open: false }" class="space-y-3">
                        <button @click="open = !open" class="w-full text-left bg-gray-50 hover:bg-gray-100 py-2 px-3 rounded-lg text-sm flex items-center transition duration-200">
                            <span class="font-medium text-gray-700">Guru Pengajar</span>
                            <svg :class="{ 'rotate-180': open }" class="ml-auto w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </button>
                        <div x-show="open" class="mt-2 space-y-2 pl-2">
                            @forelse ($item->dataGuruKelas as $guru)
                                <span class="block bg-blue-50 text-blue-700 py-2.5 px-3 rounded-lg text-sm">
                                    {{ $guru->name }}
                                </span>
                            @empty
                                <span class="text-gray-400 text-sm">Belum ada guru</span>
                            @endforelse
                        </div>
                    </div>
                </td>
                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center justify-center text-center space-x-2">
                        <x-btn-edit href="{{ url('kelas/' . $item->id . '/edit') }}"></x-btn-edit>
                        <x-btn-delete action="{{ url('kelas/' . $item->id) }}"></x-btn-delete>
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