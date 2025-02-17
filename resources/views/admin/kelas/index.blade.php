<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8">
            <x-search :search="$search" action="{{ url('jurusan/' . $jurusan->slug . '/kelas') }}">Cari Tahun Ajaran...</x-search>

            <!-- Add Class Button -->
           <x-btn-add href="{{ url('kelas/create?jurusan=' . $jurusan->id) }}" >Tambah Kelas</x-btn-add>
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