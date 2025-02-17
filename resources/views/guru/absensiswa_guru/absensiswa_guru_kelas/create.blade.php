<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="max-w-7xl mx-auto">
        <div class="" x-data="{ 
            isSubmitting: false,
        }">

            <form action="{{ url('absensiswa_guru') }}" method="post" enctype="multipart/form-data" class="p-6 space-y-6" @submit="isSubmitting = true">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mata Pelajaran Select -->
                    <div class="space-y-2">
                        <label for="mapel_id" class="block text-sm font-medium text-gray-700 flex items-center space-x-2">
                            <span>Mata Pelajaran</span>
                        </label>
                        <select id="mapel_id" name="mapel_id" 
                                class="mt-1 block w-full py-3.5 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            <option value="">--Pilih Mata Pelajaran--</option>
                            @foreach($mapel as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_mapel }}</option>
                            @endforeach
                        </select>
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
                        <label for="tgl" class="block text-sm font-medium text-gray-700 flex items-center space-x-2">
                            <span>Tanggal</span>
                        </label>
                        <input type="date" id="tgl" name="tgl" 
                               value="{{ old('tgl', date('Y-m-d')) }}" 
                               min="{{ date('Y-m-d') }}" 
                               max="{{ date('Y-m-d') }}"
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

                <div class="mt-6 overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gradient-to-r from-green-500 to-green-600">
                                <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Keterangan <span class="text-green-200 font-normal">(Kosongkan Jika Hadir)</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($data_siswa as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nama_siswa }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="hidden" name="siswa[{{ $item->id }}][keterangan]" value="Hadir">
                                        <div class="flex justify-center space-x-6">
                                            @foreach(['Sakit' => 'bg-yellow-100 text-yellow-800', 
                                                     'Izin' => 'bg-blue-100 text-blue-800', 
                                                     'Alpha' => 'bg-red-100 text-red-800'] as $status => $colors)
                                                <label class="relative inline-flex items-center group">
                                                    <input type="radio" 
                                                           class="absolute w-0 h-0 opacity-0 peer"
                                                           name="siswa[{{ $item->id }}][keterangan]" 
                                                           value="{{ $status }}"
                                                           onclick="toggleRadio(this)">
                                                    <span class="px-4 py-2 rounded-full cursor-pointer {{ $colors }} text-sm font-medium opacity-50 peer-checked:opacity-100 hover:opacity-75 transition-all duration-200">
                                                        {{ $status }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out"
                            :disabled="isSubmitting"
                            :class="{'opacity-75 cursor-not-allowed': isSubmitting}">
                        <span x-show="!isSubmitting">Simpan Absensi</span>
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

    <script>
        function toggleRadio(radio) {
            const wasChecked = radio.dataset.checked === "true";
            
            // Reset all radios in the same group
            const radios = document.getElementsByName(radio.name);
            radios.forEach(input => {
                input.checked = false;
                input.dataset.checked = "false";
            });
            
            if (!wasChecked) {
                radio.checked = true;
                radio.dataset.checked = "true";
            }
            
            // Update the hidden input value
            const hiddenInput = document.querySelector(`input[type="hidden"][name="${radio.name}"]`);
            hiddenInput.value = wasChecked ? "Hadir" : radio.value;
        }
    </script>
</x-layout>