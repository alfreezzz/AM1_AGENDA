<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="max-w-7xl mx-auto">
        <div class="">

            <form action="{{ url('absensiswa_guru') }}" method="post" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mata Pelajaran Select -->
                    <div class="space-y-2">
                        <label for="mapel_id" class="block text-sm font-medium text-gray-700 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Mata Pelajaran</span>
                        </label>
                        <select id="mapel_id" name="mapel_id" 
                                class="block w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-4 text-gray-700 shadow-sm transition duration-150 ease-in-out focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                            <option value="">--Pilih Mata Pelajaran--</option>
                            @foreach($mapel as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_mapel }}</option>
                            @endforeach
                        </select>
                        @error('mapel_id')
                            <p class="mt-1 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Tanggal Input -->
                    <div class="space-y-2">
                        <label for="tgl" class="block text-sm font-medium text-gray-700 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Tanggal</span>
                        </label>
                        <input type="date" id="tgl" name="tgl" 
                               value="{{ old('tgl', date('Y-m-d')) }}" 
                               min="{{ date('Y-m-d') }}" 
                               max="{{ date('Y-m-d') }}"
                               class="block w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-4 text-gray-700 shadow-sm transition duration-150 ease-in-out focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 @error('tgl') border-red-500 @enderror">
                        @error('tgl')
                            <p class="mt-1 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gradient-to-r from-green-500 to-green-600">
                                <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-16">No</th>
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

                <div class="flex justify-end pt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-green-500 text-white rounded-lg font-medium shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Absensi
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