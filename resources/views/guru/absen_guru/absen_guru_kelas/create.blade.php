<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="" x-data="{ 
        files: [],
        message: '',
        isSubmitting: false,
        updateMessage(type) {
            this.message = type === 'Sakit' ? 'Semoga lekas sembuh' : 'Semoga urusanmu lancar';
        }
    }">
        <div class="container mx-auto">
            <div class="">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full md:w-1/2 p-8">
                        
                        <form action="{{ url('absen_guru') }}" method="post" enctype="multipart/form-data" class="space-y-6" @submit="isSubmitting = true">
                            @csrf
                            <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

                            <!-- Mapel Selection -->
                            <div class="space-y-2">
                                <label for="mapel_id" class="text-sm font-medium text-gray-700 block">Mata Pelajaran</label>
                                <select id="mapel_id" name="mapel_id" 
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
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

                            <!-- Date Input -->
                            <div class="space-y-2">
                                <label for="tgl" class="text-sm font-medium text-gray-700 block">Tanggal</label>
                                <input type="date" id="tgl" name="tgl" 
                                    class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('tgl') border-red-500 @enderror"
                                    value="{{ old('tgl', date('Y-m-d')) }}" 
                                    min="{{ date('Y-m-d') }}" 
                                    max="{{ date('Y-m-d') }}">
                                @error('tgl')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Radio Buttons -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700 block">Keterangan</label>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="keterangan" value="Sakit" 
                                            class="form-radio text-green-500 focus:ring-green-500"
                                            x-on:change="updateMessage('Sakit')">
                                        <span class="ml-2">Sakit</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="keterangan" value="Izin" 
                                            class="form-radio text-green-500 focus:ring-green-500"
                                            x-on:change="updateMessage('Izin')">
                                        <span class="ml-2">Izin</span>
                                    </label>
                                </div>
                                @error('keterangan')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- File Upload -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700 block">Upload Tugas</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-green-500 transition-colors duration-200"
                                    x-on:drop="files = $event.dataTransfer.files"
                                    x-on:dragover.prevent="$el.classList.add('border-green-500')"
                                    x-on:dragleave.prevent="$el.classList.remove('border-green-500')">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                <span>Upload file</span>
                                                <input type="file" name="tugas[]" multiple class="sr-only" accept=".pdf" x-on:change="files = $event.target.files">

                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">pdf up to 15MB</p>
                                    </div>
                                </div>
                                <div x-show="files.length > 0" class="mt-2">
                                    <template x-for="file in files" :key="file.name">
                                        <div class="text-sm text-gray-600" x-text="file.name"></div>
                                    </template>
                                </div>
                                @error('tugas')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Task Description -->
                            <div class="space-y-2">
                                <label for="keterangantugas" class="text-sm font-medium text-gray-700 block">Keterangan Tugas</label>
                                <input type="text" id="keterangantugas" name="keterangantugas" 
                                    class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('keterangantugas') border-red-500 @enderror"
                                    value="{{ old('keterangantugas') }}"
                                    placeholder="Masukkan Keterangan Tugas">
                                @error('keterangantugas')
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

                    <!-- Image & Message Section -->
                    <div class="w-full md:w-1/2 px-8 flex flex-col justify-center items-center">
                        <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Image" 
                            class="w-full max-w-md h-auto mb-8">
                        <div x-show="message" 
                            x-text="message"
                            class="text-xl font-bold text-green-600 text-center animate-fade-in"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform -translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>