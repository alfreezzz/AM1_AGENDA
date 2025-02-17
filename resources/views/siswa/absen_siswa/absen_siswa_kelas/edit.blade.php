<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    @if (Auth::user()->role == 'Admin')
    <div class="max-w-6xl mx-auto px-4" x-data="{ 
        isSubmitting: false,
    }">
        <form action="{{ route('absen_siswa.update', $absen_siswa->id) }}" method="post" enctype="multipart/form-data" class="space-y-8" @submit="isSubmitting = true">
            @csrf
            @method('PUT')
            
            <!-- Date Input Section -->
            <div class="">
                <label for="tgl" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Absensi</label>
                <input 
                    type="date" 
                    id="tgl" 
                    name="tgl" 
                    value="{{ old('tgl', $absen_siswa->tgl) }}"
                    readonly
                    class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('tgl') border-red-500 @enderror"
                >
                @error('tgl')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Attendance Table Section -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-green-500 to-green-600">
                                <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Keterangan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 text-gray-500 text-center">1</td>
                                <td class="px-6 py-4 font-medium">{{ $absen_siswa->data_siswa->nama_siswa }}</td>
                                <td class="px-6 py-4">
                                    <input type="hidden" name="keterangan" value="Hadir">
                                    <div class="flex justify-center space-x-6" x-data="{ status: '{{ $absen_siswa->keterangan }}' }">
                                        <label class="relative inline-flex items-center group">
                                            <input type="radio" 
                                                class="absolute w-0 h-0 opacity-0 peer"
                                                name="keterangan" 
                                                value="Hadir"
                                                :checked="status === 'Hadir'"
                                                @click="status = 'Hadir'">
                                            <span class="px-4 py-2 rounded-full cursor-pointer bg-green-100 text-green-800 text-sm font-medium opacity-50 peer-checked:opacity-100 hover:opacity-75 transition-all duration-200">
                                                Hadir
                                            </span>
                                        </label>

                                        <label class="relative inline-flex items-center group">
                                            <input type="radio" 
                                                class="absolute w-0 h-0 opacity-0 peer"
                                                name="keterangan" 
                                                value="Sakit"
                                                :checked="status === 'Sakit'"
                                                @click="status = 'Sakit'">
                                            <span class="px-4 py-2 rounded-full cursor-pointer bg-yellow-100 text-yellow-800 text-sm font-medium opacity-50 peer-checked:opacity-100 hover:opacity-75 transition-all duration-200">
                                                Sakit
                                            </span>
                                        </label>

                                        <label class="relative inline-flex items-center group">
                                            <input type="radio" 
                                                class="absolute w-0 h-0 opacity-0 peer"
                                                name="keterangan" 
                                                value="Izin"
                                                :checked="status === 'Izin'"
                                                @click="status = 'Izin'">
                                            <span class="px-4 py-2 rounded-full cursor-pointer bg-blue-100 text-blue-800 text-sm font-medium opacity-50 peer-checked:opacity-100 hover:opacity-75 transition-all duration-200">
                                                Izin
                                            </span>
                                        </label>

                                        <label class="relative inline-flex items-center group">
                                            <input type="radio" 
                                                class="absolute w-0 h-0 opacity-0 peer"
                                                name="keterangan" 
                                                value="Alpha"
                                                :checked="status === 'Alpha'"
                                                @click="status = 'Alpha'">
                                            <span class="px-4 py-2 rounded-full cursor-pointer bg-red-100 text-red-800 text-sm font-medium opacity-50 peer-checked:opacity-100 hover:opacity-75 transition-all duration-200">
                                                Alpha
                                            </span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out"
                        :disabled="isSubmitting"
                        :class="{'opacity-75 cursor-not-allowed': isSubmitting}">
                    <span x-show="!isSubmitting">Update Absensi</span>
                    <span x-show="isSubmitting" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
    @elseif (Auth::user()->role == 'Sekretaris' || Auth::user()->role == 'Guru')
        <div class="min-h-[400px] flex items-center justify-center">
            <div class="text-center p-8 bg-red-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-lg font-medium text-gray-900">Akses Terbatas</p>
                <p class="mt-2 text-gray-600">Anda tidak memiliki hak untuk mengakses halaman ini.</p>
            </div>
        </div>
    @endif
</x-layout>