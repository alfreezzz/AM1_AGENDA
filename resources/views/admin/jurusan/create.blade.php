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
                            jurusan_id: '{{ old('jurusan_id') }}'
                        },
                        isSubmitting: false
                    }">
                        <div class="max-w-md mx-auto">                
                            <form action="{{ url('jurusan') }}" 
                                  method="post" 
                                  enctype="multipart/form-data" 
                                  @submit="isSubmitting = true" 
                                  class="space-y-6">
                                @csrf

                                <!-- Nama Jurusan Input -->
                                <div class="space-y-2">
                                    <label for="jurusan_id" class="text-sm font-medium text-gray-700 block">
                                        Nama Jurusan
                                        <span class="inline-flex items-center ml-1 text-gray-500">
                                            <i>(singkatan)</i>
                                            <span class="group relative ml-1">
                                                <svg class="w-4 h-4 text-gray-400 hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="hidden group-hover:block absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded whitespace-nowrap">
                                                    Gunakan singkatan jurusan (contoh: PPLG, AN, TJKT)
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               x-model="formData.jurusan_id"
                                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('jurusan_id') border-red-500 @enderror"
                                               id="jurusan_id" 
                                               name="jurusan_id" 
                                               placeholder="Masukkan singkatan jurusan">
                                    </div>
                                    @error('jurusan_id')
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
                                        <span x-show="!isSubmitting">
                                            Simpan Jurusan
                                        </span>
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