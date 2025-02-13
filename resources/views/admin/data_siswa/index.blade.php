<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <!-- Search Form -->
                <form action="{{ url('data_siswa') }}" method="GET" id="searchForm" class="flex-1 flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input 
                            type="search" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Cari siswa atau kelas..." 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        >
                    </div>
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        Cari
                    </button>
                </form>
                
                <x-btn-add href="{{ url('data_siswa/create') }}">Tambah Siswa</x-btn-add>
            </div>
        </div>

        @if($data_siswa->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="mt-4 text-lg text-gray-600">Data siswa belum ditambahkan.</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th scope="col" class="px-4 py-2">No</th>
                                <th scope="col" class="px-4 py-2">Nama Siswa</th>
                                <th scope="col" class="px-4 py-2">NIS</th>
                                <th scope="col" class="px-4 py-2">Gender</th>
                                <th scope="col" class="px-4 py-2">Kelas</th>
                                <th scope="col" class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($data_siswa as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2 text-center whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->nama_siswa }}</div>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $item->nis_id }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-center">
                                    @if ($item->gender == 'Pria')
                                        <span class="text-blue-600 text-2xl">&#9794;</span>
                                    @else
                                        <span class="text-pink-600 text-2xl">&#9792;</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $item->kelas->kelas }} {{ $item->kelas->jurusan->jurusan_id }} {{ $item->kelas->kelas_id }}
                                    </span>
                                    <span class="ml-1 text-xs text-gray-500">({{ $item->kelas->thn_ajaran }})</span>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2 text-center justify-center items-center">
                                        <x-btn-edit href="{{ url('data_siswa/' . $item->id . '/edit') }}" ></x-btn-edit>
                                        <x-btn-delete action="{{ url('data_siswa/' . $item->id) }}"></x-btn-delete>
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