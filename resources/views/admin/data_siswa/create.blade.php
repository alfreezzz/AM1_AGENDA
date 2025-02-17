<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto pb-8">
            <!-- Card Container -->
            <div class="">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full md:w-1/2 px-8" x-data="{ 
                        formData: {
                            kelas_id: '',
                            nama_siswa: '',
                            nis_id: '',
                            gender: ''
                        },
                        isSubmitting: false
                    }">
                        <div class="max-w-md mx-auto">                
                            <form action="{{ url('data_siswa') }}" method="post" enctype="multipart/form-data" 
                                  @submit="isSubmitting = true" 
                                  class="space-y-6">
                                @csrf

                                <!-- Kelas Selection -->
                                <div class="space-y-2">
                                    <label for="kelas_id" class="text-sm font-medium text-gray-700 block">
                                        Kelas
                                    </label>
                                    <div class="relative">
                                        <select x-model="formData.kelas_id"
                                                class="block w-full pl-3 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg transition duration-150 ease-in-out bg-white @error('kelas_id') border-red-500 @enderror"
                                                name="kelas_id" 
                                                id="kelas_id">
                                            <option value="">--Pilih Kelas--</option>
                                            @foreach ($kelas as $item)
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

                                <!-- Nama Siswa Input -->
                                <div class="space-y-2">
                                    <label for="nama_siswa" class="text-sm font-medium text-gray-700 block">
                                        Nama Siswa
                                    </label>
                                    <input type="text" 
                                           x-model="formData.nama_siswa"
                                           class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('nama_siswa') border-red-500 @enderror"
                                           id="nama_siswa" 
                                           name="nama_siswa" 
                                           value="{{ old('nama_siswa') }}"
                                           placeholder="Masukkan nama lengkap">
                                        @error('nama_siswa')
                                           <p class="mt-2 text-sm text-red-600 flex items-center">
                                               <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                   <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                               </svg>
                                               {{ $message }}
                                           </p>
                                       @enderror
                                </div>

                                <!-- NIS Input -->
                                <div class="space-y-2">
                                    <label for="nis_id" class="text-sm font-medium text-gray-700 block">
                                        NIS
                                    </label>
                                    <input type="number" 
                                           x-model="formData.nis_id"
                                           class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('nis_id') border-red-500 @enderror"
                                           id="nis_id" 
                                           name="nis_id" 
                                           value="{{ old('nis_id') }}"
                                           placeholder="Masukkan NIS">
                                        @error('nis_id')
                                           <p class="mt-2 text-sm text-red-600 flex items-center">
                                               <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                   <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                               </svg>
                                               {{ $message }}
                                           </p>
                                       @enderror
                                </div>

                                <!-- Gender Selection -->
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700 block">Gender</label>
                                    <div class="flex space-x-6">
                                        <div class="flex items-center">
                                            <input type="radio" 
                                                   x-model="formData.gender"
                                                   id="gender_pria" 
                                                   name="gender" 
                                                   value="Pria"
                                                   class="h-4 w-4 text-green-500 focus:ring-green-500 border-gray-300">
                                            <label for="gender_pria" class="ml-3 text-sm text-gray-700 flex items-center">
                                                <span class="text-blue-500 text-lg mr-1">♂</span> Laki-laki
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" 
                                                   x-model="formData.gender"
                                                   id="gender_wanita" 
                                                   name="gender" 
                                                   value="Wanita"
                                                   class="h-4 w-4 text-green-500 focus:ring-green-500 border-gray-300">
                                            <label for="gender_wanita" class="ml-3 text-sm text-gray-700 flex items-center">
                                                <span class="text-pink-500 text-lg mr-1">♀</span> Perempuan
                                            </label>
                                        </div>
                                    </div>
                                    @error('gender')
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
                                        <span x-show="!isSubmitting">Simpan Data</span>
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

                    <!-- Image Section -->
                    <div class="w-full md:w-1/2 px-8 flex items-center justify-center">
                        <div class="relative">
                            <div class="absolute inset-0"></div>
                            <img src="{{ asset('assets/images/hero.png') }}" 
                                 alt="Hero Image" 
                                 class="relative z-10 w-96 h-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>