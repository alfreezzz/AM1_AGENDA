<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="max-w-7xl mx-auto">
        <div class="max-w-6xl mx-auto px-4" x-data="{ 
            currentDate: new Date().toISOString().split('T')[0],
            isSubmitting: false
        }">
            <form action="{{ url('absensiswa_guru/'. $absensi->id) }}" method="post" enctype="multipart/form-data" class="p-6 space-y-6" @submit="isSubmitting = true">
                @csrf
                @method('PUT')
                <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mata Pelajaran Select -->
                    <div class="relative">
                        <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                        @if(isset($absensi))
                            <input type="text" 
                                   class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm bg-gray-100"
                                   value="{{ $absensi->mapel->nama_mapel }}" 
                                   disabled>
                            <input type="hidden" name="mapel_id" value="{{ $absensi->mapel_id }}">
                        @else
                            <select id="mapel_id" 
                                    name="mapel_id" 
                                    class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('mapel_id') border-red-500 @enderror">
                                <option value="">--Pilih Mata Pelajaran--</option>
                                @foreach($mapel as $item)
                                    <option value="{{ $item->id }}" {{ old('mapel_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        @error('mapel_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tanggal Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 flex items-center space-x-2">
                            <span>Tanggal</span>
                        </label>
                        <input type="date" name="tgl" 
                               value="{{ old('tgl', $absensi->tgl) }}" 
                               readonly
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('tgl') border-red-500 @enderror">
                        @error('tgl')
                           <p class="mt-2 text-sm text-red-600 flex items-center">
                               <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                   <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                               </svg>
                               {{ $message }}
                           </p>
                        @enderror
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-green-600 to-green-700">
                                    <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider w-16">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Siswa</th>
                                    <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">
                                        Keterangan
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">Surat Sakit</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50 transition duration-150" x-data="{ attendance: '{{ $absensi->keterangan }}' }">
                                    <td class="px-6 py-4 text-gray-500 text-center">1</td>
                                    <td class="px-6 py-4 font-medium text-gray-800">{{ $absensi->data_siswa->nama_siswa }}</td>
                                    <td class="px-6 py-4">
                                        <input type="hidden" name="keterangan" :value="attendance === null ? 'Hadir' : attendance">
                                        <div class="flex justify-center space-x-4">
                                            <label class="relative inline-flex items-center group">
                                                <input type="radio" 
                                                    class="absolute w-0 h-0 opacity-0 peer"
                                                    x-model="attendance"
                                                    value="Hadir"
                                                    @click="attendance = (attendance === 'Hadir') ? null : 'Hadir'">
                                                <span class="px-4 py-2 rounded-full cursor-pointer border bg-green-100 text-green-800 border-green-300 text-sm font-medium opacity-60 hover:opacity-80 transition-all duration-200"
                                                    :class="{'opacity-100 ring-2 ring-offset-2 ring-green-400': attendance === 'Hadir'}">
                                                    Hadir
                                                </span>
                                            </label>
                                            
                                            <label class="relative inline-flex items-center group">
                                                <input type="radio" 
                                                    class="absolute w-0 h-0 opacity-0 peer"
                                                    x-model="attendance"
                                                    value="Sakit"
                                                    @click="attendance = (attendance === 'Sakit') ? null : 'Sakit'">
                                                <span class="px-4 py-2 rounded-full cursor-pointer border bg-yellow-100 text-yellow-800 border-yellow-300 text-sm font-medium opacity-60 hover:opacity-80 transition-all duration-200"
                                                    :class="{'opacity-100 ring-2 ring-offset-2 ring-yellow-400': attendance === 'Sakit'}">
                                                    Sakit
                                                </span>
                                            </label>

                                            <label class="relative inline-flex items-center group">
                                                <input type="radio" 
                                                    class="absolute w-0 h-0 opacity-0 peer"
                                                    x-model="attendance"
                                                    value="Izin"
                                                    @click="attendance = (attendance === 'Izin') ? null : 'Izin'">
                                                <span class="px-4 py-2 rounded-full cursor-pointer border bg-blue-100 text-blue-800 border-blue-300 text-sm font-medium opacity-60 hover:opacity-80 transition-all duration-200"
                                                    :class="{'opacity-100 ring-2 ring-offset-2 ring-blue-400': attendance === 'Izin'}">
                                                    Izin
                                                </span>
                                            </label>

                                            <label class="relative inline-flex items-center group">
                                                <input type="radio" 
                                                    class="absolute w-0 h-0 opacity-0 peer"
                                                    x-model="attendance"
                                                    value="Alpha"
                                                    @click="attendance = (attendance === 'Alpha') ? null : 'Alpha'">
                                                <span class="px-4 py-2 rounded-full cursor-pointer border bg-red-100 text-red-800 border-red-300 text-sm font-medium opacity-60 hover:opacity-80 transition-all duration-200"
                                                    :class="{'opacity-100 ring-2 ring-offset-2 ring-red-400': attendance === 'Alpha'}">
                                                    Alpha
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div x-show="attendance === 'Sakit'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Surat Sakit</label>
                                            <input 
                                                type="file" 
                                                name="surat_sakit" 
                                                accept="image/*,.pdf" 
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                                            >
                                        </div>
                                        @error('surat_sakit')
                                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                        @enderror
                                        <div x-show="attendance !== 'Sakit'" class="text-gray-400 text-sm italic text-center">
                                            -
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pt-6">
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
    </div>
</x-layout>