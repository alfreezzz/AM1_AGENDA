<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    
    <div class="p-6 mx-auto space-y-6 max-w-7xl">
        @if(session('status'))
                <div class="bg-gradient-to-r from-gray-700 to-gray-900 border-b border-gray-900 text-[#C7EEFF] text-center p-4 rounded-lg mb-4">
                    <h1 class="text-sm font-bold tracking-wide text-center text-white transition-transform duration-300 sm:text-lg drop-shadow-lg hover:scale-105">{{ session('status') }}</h1>
                </div>
            @endif
        <!-- Header Section -->
        <div class="flex justify-end">
           <x-btn-add href="{{ url('jurusan/create') }}">Tambah Jurusan</x-btn-add>
        </div>

        @if($jurusan->isEmpty())
            <div class="p-8 bg-white border border-gray-100 shadow-sm rounded-xl">
                <div class="flex flex-col items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <p class="text-lg text-gray-600">Data jurusan belum ditambahkan.</p>
                    <a href="{{ url('jurusan/create') }}" class="font-medium text-green-500 hover:text-green-600">
                        Tambah data sekarang
                    </a>
                </div>
            </div>
        @else
            <div class="overflow-hidden bg-white border border-gray-100 shadow-sm rounded-xl">
                <div class="bg-white border border-gray-100 shadow-lg rounded-xl" x-data="{ 
                    confirmDelete(event) {
                        if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                            event.preventDefault();
                        }
                    }
                }">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-sm font-medium tracking-wider text-center text-gray-500 uppercase bg-gray-50">
                                    <th class="px-4 py-2">
                                        No
                                    </th>
                                    <th class="px-4 py-2">
                                        Nama Jurusan
                                    </th>
                                    <th class="px-4 py-2">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($jurusan as $item)
                                    <tr class="transition-colors duration-200 hover:bg-gray-50">
                                        <td class="px-4 py-2 text-sm text-center text-gray-500 whitespace-nowrap">
                                            {{ $loop->iteration + ($jurusan->currentPage() - 1) * $jurusan->perPage() }}
                                        </td>
                                        <td class="px-4 py-2 text-sm font-bold text-gray-600 whitespace-nowrap">
                                            {{ $item->jurusan_id }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-600 whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-3 text-center">
                                                <x-btn-view href="{{ url('jurusan/' . $item->slug . '/kelas') }}">View Kelas</x-btn-view>
                                                <x-btn-edit href="{{ url('jurusan/' . $item->id . '/edit') }}" ></x-btn-edit>
                                                <x-btn-delete action="{{ url('jurusan/' . $item->id) }}"></x-btn-delete>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="py-4 border-t border-gray-200">
                        {{ $jurusan->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layout>