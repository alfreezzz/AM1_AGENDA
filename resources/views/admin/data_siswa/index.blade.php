<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-8">
        @if(session('status'))
                <div class="bg-gradient-to-r from-gray-700 to-gray-900 border-b border-gray-900 text-[#C7EEFF] text-center p-4 rounded-lg mb-4">
                    <h1 class="text-sm sm:text-lg font-bold tracking-wide text-white text-center drop-shadow-lg hover:scale-105 transition-transform duration-300">{{ session('status') }}</h1>
                </div>
            @endif
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <!-- Search Form -->
                <form action="{{ url('data_siswa') }}" method="GET" 
                    class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
                    <div class="relative flex-grow">
                        <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari Siswa atau Kelas..."
                                class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" />
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400 hover:text-green-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
                
                <x-btn-add href="{{ url('data_siswa/create') }}">Tambah Siswa</x-btn-add>
            </div>
        </div>

        @if($data_siswa->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 "  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
    <path d="M2.5 6L8 4L13.5 6L11 7.5V9C11 9 10.3333 8.5 8 8.5C5.66667 8.5 5 9 5 9V7.5L2.5 6ZM2.5 6V10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
    <path d="M11 8.5V9.38889C11 11.1071 9.65685 12.5 8 12.5C6.34315 12.5 5 11.1071 5 9.38889V8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
    <path d="M15.3182 11.0294C15.3182 11.0294 15.803 10.6765 17.5 10.6765C19.197 10.6765 19.6818 11.0294 19.6818 11.0294M15.3182 11.0294V10L13.5 9L17.5 7.5L21.5 9L19.6818 10V11.0294M15.3182 11.0294V11.3182C15.3182 12.5232 16.295 13.5 17.5 13.5C18.705 13.5 19.6818 12.5232 19.6818 11.3182V11.0294" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
    <path d="M4.38505 15.926C3.44187 16.4525 0.96891 17.5276 2.47511 18.8729C3.21087 19.53 4.03033 20 5.06058 20H10.9394C11.9697 20 12.7891 19.53 13.5249 18.8729C15.0311 17.5276 12.5581 16.4525 11.6149 15.926C9.40321 14.6913 6.59679 14.6913 4.38505 15.926Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
    <path d="M16 20H19.7048C20.4775 20 21.0921 19.624 21.6439 19.0983C22.7736 18.0221 20.9189 17.162 20.2115 16.7408C18.9362 15.9814 17.3972 15.8059 16 16.2141" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="mt-4 text-lg text-gray-600">Data siswa belum ditambahkan.</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-100">
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
                                <td class="px-4 py-2 text-center whitespace-nowrap text-sm text-gray-500">
                                    {{ $loop->iteration + ($data_siswa->currentPage() - 1) * $data_siswa->perPage() }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->nama_siswa }}</div>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 text-center">{{ $item->nis_id }}</td>
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
                    <div class="my-4 px-4">
                        {{ $data_siswa->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layout>