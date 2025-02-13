<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto max-w-4xl">
            @if (Auth::user()->role == 'Admin')
                <div class="overflow-hidden">
                    <div class="py-8">

                        <form action="{{ route('absen_siswa.update', $absen_siswa->id) }}" method="post" 
                            enctype="multipart/form-data"
                            x-data="{ keterangan: '{{ $absen_siswa->keterangan }}' }">
                            @csrf
                            @method('PUT')

                            <!-- Date Field -->
                            <div class="mb-6">
                                <label class="text-sm font-medium text-gray-700">Tanggal</label>
                                <div class="relative mt-1">
                                    <input type="date" name="tgl" 
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('tgl') border-red-500 @enderror"
                                        value="{{ old('tgl', $absen_siswa->tgl) }}" 
                                        readonly>
                                    @error('tgl')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Attendance Table -->
                            <div class="relative rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <th scope="col" class="px-4 py-2">No</th>
                                            <th scope="col" class="px-4 py-2">Nama Siswa</th>
                                            <th scope="col" class="px-4 py-2">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center">1</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                {{ $absen_siswa->data_siswa->nama_siswa }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <div class="flex flex-wrap justify-center gap-4">
                                                    <!-- Hadir -->
                                                    <label class="relative flex cursor-pointer items-center rounded-full p-3 hover:bg-gray-50"
                                                        :class="{ 'ring-2 ring-green-500 bg-green-50': keterangan === 'Hadir' }">
                                                        <input type="radio" name="keterangan" value="Hadir"
                                                            class="sr-only" x-model="keterangan">
                                                        <span class="flex items-center justify-center">
                                                            <span class="w-4 h-4 border rounded-full flex items-center justify-center"
                                                                :class="{ 'border-green-500 bg-green-500': keterangan === 'Hadir' }">
                                                                <span class="w-2 h-2 rounded-full bg-white" x-show="keterangan === 'Hadir'"></span>
                                                            </span>
                                                            <span class="ml-2 text-sm font-medium text-gray-900">Hadir</span>
                                                        </span>
                                                    </label>

                                                    <!-- Sakit -->
                                                    <label class="relative flex cursor-pointer items-center rounded-full p-3 hover:bg-gray-50"
                                                        :class="{ 'ring-2 ring-yellow-500 bg-yellow-50': keterangan === 'Sakit' }">
                                                        <input type="radio" name="keterangan" value="Sakit"
                                                            class="sr-only" x-model="keterangan">
                                                        <span class="flex items-center justify-center">
                                                            <span class="w-4 h-4 border rounded-full flex items-center justify-center"
                                                                :class="{ 'border-yellow-500 bg-yellow-500': keterangan === 'Sakit' }">
                                                                <span class="w-2 h-2 rounded-full bg-white" x-show="keterangan === 'Sakit'"></span>
                                                            </span>
                                                            <span class="ml-2 text-sm font-medium text-gray-900">Sakit</span>
                                                        </span>
                                                    </label>

                                                    <!-- Izin -->
                                                    <label class="relative flex cursor-pointer items-center rounded-full p-3 hover:bg-gray-50"
                                                        :class="{ 'ring-2 ring-blue-500 bg-blue-50': keterangan === 'Izin' }">
                                                        <input type="radio" name="keterangan" value="Izin"
                                                            class="sr-only" x-model="keterangan">
                                                        <span class="flex items-center justify-center">
                                                            <span class="w-4 h-4 border rounded-full flex items-center justify-center"
                                                                :class="{ 'border-blue-500 bg-blue-500': keterangan === 'Izin' }">
                                                                <span class="w-2 h-2 rounded-full bg-white" x-show="keterangan === 'Izin'"></span>
                                                            </span>
                                                            <span class="ml-2 text-sm font-medium text-gray-900">Izin</span>
                                                        </span>
                                                    </label>

                                                    <!-- Alpha -->
                                                    <label class="relative flex cursor-pointer items-center rounded-full p-3 hover:bg-gray-50"
                                                        :class="{ 'ring-2 ring-red-500 bg-red-50': keterangan === 'Alpha' }">
                                                        <input type="radio" name="keterangan" value="Alpha"
                                                            class="sr-only" x-model="keterangan">
                                                        <span class="flex items-center justify-center">
                                                            <span class="w-4 h-4 border rounded-full flex items-center justify-center"
                                                                :class="{ 'border-red-500 bg-red-500': keterangan === 'Alpha' }">
                                                                <span class="w-2 h-2 rounded-full bg-white" x-show="keterangan === 'Alpha'"></span>
                                                            </span>
                                                            <span class="ml-2 text-sm font-medium text-gray-900">Alpha</span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-8 flex justify-end">
                                <button type="submit" 
                                    class="inline-flex items-center px-4 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                    Update Absensi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif (Auth::user()->role == 'Sekretaris' || Auth::user()->role == 'Guru')
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <div class="mb-4">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Akses Terbatas</h3>
                    <p class="text-gray-600">Anda tidak memiliki hak untuk mengakses halaman ini.</p>
                </div>
            @endif
        </div>
    </div>
</x-layout>