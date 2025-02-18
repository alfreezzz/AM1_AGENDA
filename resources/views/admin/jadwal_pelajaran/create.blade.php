<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto pb-8">
            <div class="">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full px-8">
                        @if (Auth::user()->role == 'Admin')
                            <div x-data="{ 
                                formData: {
                                    hari: '',
                                    jam_ke: [],
                                    kelas_id: '',
                                    guru_id: '',
                                    mapel_id: '',
                                    thn_ajaran: ''
                                },
                                isSubmitting: false,
                                guruList: [],
                                mapelList: [],
                                isGuruDisabled: true,
                                isMapelDisabled: true,
                                async loadGuru() {
                                    if (this.formData.kelas_id) {
                                        const response = await fetch(`/get-guru/${this.formData.kelas_id}`);
                                        this.guruList = await response.json();
                                        this.isGuruDisabled = false;
                                        this.formData.guru_id = '';
                                        this.formData.mapel_id = '';
                                        this.isMapelDisabled = true;
                                    }
                                },
                                async loadMapel() {
                                    if (this.formData.guru_id) {
                                        const response = await fetch(`/get-mapel/${this.formData.guru_id}`);
                                        this.mapelList = await response.json();
                                        this.isMapelDisabled = false;
                                        this.formData.mapel_id = '';
                                    }
                                },
                                init() {
                                    const today = new Date();
                                    const currentYear = today.getFullYear();
                                    const currentMonth = today.getMonth() + 1; // getMonth() dimulai dari 0 (Januari = 0)
                                    
                                    // Jika bulan sekarang sebelum Juli (Januari - Juni), gunakan tahun sebelumnya
                                    const startYear = currentMonth < 7 ? currentYear - 1 : currentYear;
                                    this.formData.thn_ajaran = `${startYear}/${startYear + 1}`;
                                },
                                formatTahunAjaran() {
                                    let value = this.formData.thn_ajaran.replace(/\D/g, '');
                                    if (value.length >= 4) {
                                        const tahun1 = value.substr(0, 4);
                                        const tahun2 = String(Number(tahun1) + 1);
                                        this.formData.thn_ajaran = `${tahun1}/${tahun2}`;
                                    }
                                }
                            }">
                                
                                <form action="{{ url('jadwal_pelajaran') }}" method="post" enctype="multipart/form-data" 
                                      @submit="isSubmitting = true" 
                                      class="space-y-6">
                                    @csrf

                                    <!-- Hari Selection -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-700 block">Hari</label>
                                        <div class="relative">
                                            <select x-model="formData.hari"
                                                    class="block w-full pl-3 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg transition duration-150 ease-in-out bg-white @error('hari') border-red-500 @enderror"
                                                    name="hari">
                                                <option value="">--Pilih Hari--</option>
                                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                                                    <option value="{{ $hari }}">{{ $hari }}</option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('hari')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Jam Pelajaran Selection -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-700 block">Jam Pelajaran</label>
                                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                                            @for ($i = 1; $i <= 10; $i++)
                                                <label class="relative flex items-center p-3 rounded-lg border border-gray-200 hover:border-green-500 cursor-pointer transition-colors">
                                                    <input type="checkbox" 
                                                           name="jam_ke[]" 
                                                           value="{{ $i }}"
                                                           x-model="formData.jam_ke"
                                                           class="h-4 w-4 text-green-500 focus:ring-green-500 border border-gray-300 rounded">
                                                    <span class="ml-3 text-sm">Jam {{ $i }}</span>
                                                </label>
                                            @endfor
                                        </div>
                                        @error('jam_ke')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Kelas Selection -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-700 block">Kelas</label>
                                        <div class="relative">
                                            <select x-model="formData.kelas_id"
                                                    @change="loadGuru()"
                                                    class="block w-full pl-3 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg transition duration-150 ease-in-out bg-white @error('kelas_id') border-red-500 @enderror"
                                                    name="kelas_id">
                                                <option value="">--Pilih Kelas--</option>
                                                @foreach($kelas as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }} ({{ $item->thn_ajaran }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('kelas_id')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Guru Selection -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-700 block">Guru</label>
                                        <div class="relative">
                                            <select x-model="formData.guru_id"
                                                    @change="loadMapel()"
                                                    :disabled="isGuruDisabled"
                                                    class="block w-full pl-3 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg transition duration-150 ease-in-out bg-white disabled:bg-gray-100 @error('guru_id') border-red-500 @enderror"
                                                    name="guru_id">
                                                <option value="">--Pilih Guru--</option>
                                                <template x-for="guru in guruList" :key="guru.id">
                                                    <option :value="guru.id" x-text="guru.name"></option>
                                                </template>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('guru_id')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Mapel Selection -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-700 block">Mata Pelajaran</label>
                                        <div class="relative">
                                            <select x-model="formData.mapel_id"
                                                    :disabled="isMapelDisabled"
                                                    class="block w-full pl-3 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg transition duration-150 ease-in-out bg-white disabled:bg-gray-100 @error('mapel_id') border-red-500 @enderror"
                                                    name="mapel_id">
                                                <option value="">--Pilih Mata Pelajaran--</option>
                                                <template x-for="mapel in mapelList" :key="mapel.id">
                                                    <option :value="mapel.id" x-text="mapel.nama_mapel"></option>
                                                </template>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('mapel_id')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Tahun Ajaran Input -->
                                    <div class="space-y-2">
                                        <label for="thn_ajaran" class="block text-sm font-medium text-gray-700">
                                            Tahun Ajaran <span class="text-gray-500 italic">Format: 2024/2025</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text" 
                                                   x-model="formData.thn_ajaran"
                                                   @input="formatTahunAjaran"
                                                   class="block w-full px-4 py-3 border border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('thn_ajaran') border-red-500 @enderror"
                                                   id="thn_ajaran" 
                                                   name="thn_ajaran"
                                                   placeholder="YYYY/YYYY"
                                                   maxlength="9"
                                                   value="{{ old('thn_ajaran') }}">
                                        </div>
                                        @error('thn_ajaran')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="pt-4">
                                        <button type="submit" 
                                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out"
                                                :disabled="isSubmitting"
                                                :class="{'opacity-75 cursor-not-allowed': isSubmitting}">
                                            <span x-show="!isSubmitting">Simpan Jadwal</span>
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
            </div>
        </div>
    </div>
                    @elseif (Auth::user()->role == 'Sekretaris' || Auth::user()->role == 'Guru')
                        <p class="text-center mt-4">Anda tidak memiliki hak untuk mengakses halaman ini.</p>
                    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let kelasSelect = document.getElementById("kelas_id");
            let guruSelect = document.getElementById("guru_id");
            let mapelSelect = document.getElementById("mapel_id");
    
            // Nonaktifkan guru dan mapel pada awalnya
            guruSelect.disabled = true;
            mapelSelect.disabled = true;
    
            kelasSelect.addEventListener("change", function () {
                let kelas_id = this.value;
    
                // Reset dropdown guru dan mapel
                guruSelect.innerHTML = '<option value="">--Pilih Guru--</option>';
                mapelSelect.innerHTML = '<option value="">--Pilih Mata Pelajaran--</option>';
                guruSelect.disabled = true;
                mapelSelect.disabled = true;
    
                if (kelas_id) {
                    fetch(`/get-guru/${kelas_id}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                guruSelect.disabled = false; // Aktifkan guru
                                data.forEach(guru => {
                                    let option = document.createElement("option");
                                    option.value = guru.id;
                                    option.textContent = guru.name;
                                    guruSelect.appendChild(option);
                                });
                            }
                        });
                }
            });
    
            guruSelect.addEventListener("change", function () {
                let guru_id = this.value;
    
                // Reset dropdown mapel
                mapelSelect.innerHTML = '<option value="">--Pilih Mata Pelajaran--</option>';
                mapelSelect.disabled = true;
    
                if (guru_id) {
                    fetch(`/get-mapel/${guru_id}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                mapelSelect.disabled = false; // Aktifkan mapel
                                data.forEach(mapel => {
                                    let option = document.createElement("option");
                                    option.value = mapel.id;
                                    option.textContent = mapel.nama_mapel;
                                    mapelSelect.appendChild(option);
                                });
                            }
                        });
                }
            });
        });
    </script>
    
</x-layout>
