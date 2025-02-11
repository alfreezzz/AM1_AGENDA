<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="p-6 max-w-7xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="flex justify-end">
            <a href="{{ url('jurusan/create') }}" class="inline-flex items-center gap-2 bg-green-500 text-white py-2.5 px-4 rounded-lg hover:bg-green-600 transition-all duration-300 shadow hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Data Jurusan
            </a>
        </div>

        @if($jurusan->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="flex flex-col items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <p class="text-gray-600 text-lg">Data jurusan belum ditambahkan.</p>
                    <a href="{{ url('jurusan/create') }}" class="text-green-500 hover:text-green-600 font-medium">
                        Tambah data sekarang
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto" x-data="{ 
                    confirmDelete(event) {
                        if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                            event.preventDefault();
                        }
                    }
                }">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-center text-sm font-medium text-gray-500 uppercase tracking-wider w-20">
                                    No
                                </th>
                                <th class="px-4 py-2 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Jurusan
                                </th>
                                <th class="px-4 py-2 text-center text-sm font-medium text-gray-500 uppercase tracking-wider w-72">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($jurusan as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-4 py-2 text-center whitespace-nowrap text-sm text-gray-600">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">
                                        {{ $item->jurusan_id }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex text-center justify-center items-center gap-3">
                                            <a href="{{ url('jurusan/' . $item->slug . '/kelas') }}" 
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View Kelas
                                            </a>
                                            <a href="{{ url('jurusan/' . $item->id . '/edit') }}" 
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ url('jurusan/' . $item->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        @click="confirmDelete($event)"
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
            </div>
        @endif
    </div>
</x-layout>