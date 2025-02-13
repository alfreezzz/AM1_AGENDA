<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto">
            <div class="overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full px-8">
                        @if (Auth::user()->role == 'Admin')

                            <form action="{{ url('jadwal_pelajaran/' . $jadwal->id) }}" method="post" enctype="multipart/form-data" class="space-y-6">
                                @method('PUT')
                                @csrf

                                <!-- Hari -->
                                <div class="space-y-2">
                                    <label for="hari" class="text-sm font-medium text-gray-900">Hari</label>
                                    <select class="w-full rounded-lg border-gray-200 bg-gray-50 p-3 text-sm focus:border-green-500 focus:ring-green-500 @error('hari') border-red-500 @enderror" name="hari" id="hari">
                                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                                            <option value="{{ $day }}" {{ $jadwal->hari == $day ? 'selected' : '' }}>{{ $day }}</option>
                                        @endforeach
                                    </select>
                                    @error('hari')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jam Pelajaran -->
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-900">Jam Pelajaran</label>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 bg-gray-50 p-4 rounded-lg">
                                        @for ($i = 1; $i <= 10; $i++)
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="jam_ke_{{ $i }}" name="jam_ke[]" value="{{ $i }}" 
                                                    class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500"
                                                    {{ is_array($jadwal->jam_ke) && in_array($i, $jadwal->jam_ke) ? 'checked' : '' }}>
                                                <label for="jam_ke_{{ $i }}" class="text-sm text-gray-700">Jam {{ $i }}</label>
                                            </div>
                                        @endfor
                                    </div>
                                    @error('jam_ke')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kelas -->
                                <div class="space-y-2">
                                    <label for="kelas_id" class="text-sm font-medium text-gray-900">Kelas</label>
                                    <select class="w-full rounded-lg border-gray-200 bg-gray-50 p-3 text-sm focus:border-green-500 focus:ring-green-500 @error('kelas_id') border-red-500 @enderror" name="kelas_id" id="kelas_id">
                                        @foreach($kelas as $item)
                                            <option value="{{ $item->id }}" {{ $jadwal->kelas_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }} ({{ $item->thn_ajaran }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Guru -->
                                <div class="space-y-2">
                                    <label for="guru_id" class="text-sm font-medium text-gray-900">Guru</label>
                                    <select class="w-full rounded-lg border-gray-200 bg-gray-50 p-3 text-sm focus:border-green-500 focus:ring-green-500 @error('guru_id') border-red-500 @enderror" name="guru_id" id="guru_id">
                                        @foreach($user as $item)
                                            <option value="{{ $item->id }}" {{ $jadwal->guru_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('guru_id')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mata Pelajaran -->
                                <div class="space-y-2">
                                    <label for="mapel_id" class="text-sm font-medium text-gray-900">Mata Pelajaran</label>
                                    <select class="w-full rounded-lg border-gray-200 bg-gray-50 p-3 text-sm focus:border-green-500 focus:ring-green-500 @error('mapel_id') border-red-500 @enderror" name="mapel_id" id="mapel_id">
                                        @foreach($mapel as $item)
                                            <option value="{{ $item->id }}" {{ $jadwal->mapel_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_mapel }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mapel_id')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tahun Ajaran -->
                                <div class="space-y-2">
                                    <label for="thn_ajaran" class="text-sm font-medium text-gray-900">Tahun Ajaran</label>
                                    <input type="text" class="w-full rounded-lg border-gray-200 bg-gray-50 p-3 text-sm focus:border-green-500 focus:ring-green-500 @error('thn_ajaran') border-red-500 @enderror" id="thn_ajaran" name="thn_ajaran" value="{{ $jadwal->thn_ajaran }}" placeholder="Contoh: 2023/2024">
                                    @error('thn_ajaran')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-4">
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="flex flex-col items-center justify-center h-full p-8 text-center">
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                Anda tidak memiliki hak untuk mengakses halaman ini.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const kelasSelect = document.getElementById("kelas_id");
            const guruSelect = document.getElementById("guru_id");
            const mapelSelect = document.getElementById("mapel_id");
            
            // Add loading states
            function setLoading(element, isLoading) {
                element.disabled = isLoading;
                if (isLoading) {
                    element.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    element.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            // Initial state
            setLoading(guruSelect, true);
            setLoading(mapelSelect, true);

            kelasSelect.addEventListener("change", async function () {
                const kelas_id = this.value;
                
                // Reset and disable dependent dropdowns
                guruSelect.innerHTML = '<option value="">--Pilih Guru--</option>';
                mapelSelect.innerHTML = '<option value="">--Pilih Mata Pelajaran--</option>';
                setLoading(guruSelect, true);
                setLoading(mapelSelect, true);

                if (kelas_id) {
                    try {
                        const response = await fetch(`/get-guru/${kelas_id}`);
                        const data = await response.json();
                        
                        if (data.length > 0) {
                            setLoading(guruSelect, false);
                            data.forEach(guru => {
                                const option = document.createElement("option");
                                option.value = guru.id;
                                option.textContent = guru.name;
                                guruSelect.appendChild(option);
                            });
                        }
                    } catch (error) {
                        console.error("Error fetching guru data:", error);
                    }
                }
            });

            guruSelect.addEventListener("change", async function () {
                const guru_id = this.value;
                
                // Reset and disable mapel dropdown
                mapelSelect.innerHTML = '<option value="">--Pilih Mata Pelajaran--</option>';
                setLoading(mapelSelect, true);

                if (guru_id) {
                    try {
                        const response = await fetch(`/get-mapel/${guru_id}`);
                        const data = await response.json();
                        
                        if (data.length > 0) {
                            setLoading(mapelSelect, false);
                            data.forEach(mapel => {
                                const option = document.createElement("option");
                                option.value = mapel.id;
                                option.textContent = mapel.nama_mapel;
                                mapelSelect.appendChild(option);
                            });
                        }
                    } catch (error) {
                        console.error("Error fetching mapel data:", error);
                    }
                }
            });
        });
    </script>
</x-layout>