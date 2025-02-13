<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto">
            <div class="overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <!-- Form Section -->
                    <div class="w-full lg:w-1/2 p-6 sm:px-8">
                        <form action="{{ url('absen_guru/' . $absen_guru->id) }}" method="post" enctype="multipart/form-data"
                            x-data="{ 
                                keterangan: '{{ old('keterangan', $absen_guru->keterangan) }}',
                                files: [],
                                message: ''
                            }"
                            x-init="$watch('keterangan', value => {
                                message = value === 'Sakit' ? 'Semoga lekas sembuh' : 
                                         value === 'Izin' ? 'Semoga urusanmu lancar' : '';
                            })"
                            class="space-y-6"
                        >
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

                            <!-- Mapel Field -->
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700">Mata Pelajaran</label>
                                <div class="relative">
                                    <input type="text" class="w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" 
                                        value="{{ $absen_guru->mapel->nama_mapel }}" disabled>
                                    <input type="hidden" name="mapel_id" value="{{ $absen_guru->mapel_id }}">
                                </div>
                            </div>

                            <!-- Tanggal Field -->
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" name="tgl" 
                                    class="w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('tgl') border-red-500 @enderror"
                                    value="{{ old('tgl', $absen_guru->tgl) }}" readonly>
                                @error('tgl')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Keterangan Field -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Keterangan</label>
                                <div class="flex space-x-4">
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" name="keterangan" value="Sakit" 
                                            x-model="keterangan"
                                            class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                        <span class="text-gray-700">Sakit</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" name="keterangan" value="Izin" 
                                            x-model="keterangan"
                                            class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                        <span class="text-gray-700">Izin</span>
                                    </label>
                                </div>
                                @error('keterangan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- File Upload -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Upload Tugas</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-green-500 transition-colors duration-200"
                                    x-on:dragover.prevent="$el.classList.add('border-green-500')"
                                    x-on:dragleave.prevent="$el.classList.remove('border-green-500')"
                                    x-on:drop.prevent="
                                        $el.classList.remove('border-green-500');
                                        files = [...files, ...$event.dataTransfer.files]
                                    ">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                <span>Upload files</span>
                                                <input type="file" name="tugas[]" class="sr-only" multiple
                                                    x-on:change="files = [...$event.target.files]">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF up to 15MB</p>
                                    </div>
                                </div>
                                <!-- File Preview -->
                                <div class="mt-2 space-y-2" x-show="files.length > 0">
                                    <template x-for="file in files" :key="file.name">
                                        <div class="flex items-center space-x-2 p-2 bg-gray-50 rounded">
                                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-sm text-gray-500" x-text="file.name"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Keterangan Tugas -->
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700">Keterangan Tugas</label>
                                <input type="text" name="keterangantugas" 
                                    class="w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('keterangantugas') border-red-500 @enderror"
                                    value="{{ old('keterangantugas', $absen_guru->keterangantugas) }}">
                                @error('keterangantugas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                    Update Absensi
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Image Section -->
                    <div class="w-full lg:w-1/2 px-6 sm:px-8 flex flex-col justify-center items-center">
                        <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Image" 
                            class="w-full max-w-md h-auto mb-6">
                        <div x-text="message" 
                            class="text-xl font-medium text-green-600 text-center animate-fade-in"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
    </style>
</x-layout>