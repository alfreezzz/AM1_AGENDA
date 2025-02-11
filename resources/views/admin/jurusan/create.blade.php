<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto">
            <div class="overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full md:w-1/2 px-8" x-data="{ 
                        formData: {
                            jurusan_id: ''
                        },
                        isSubmitting: false,
                        isUpperCase: false,
                        formatInput() {
                            this.formData.jurusan_id = this.isUpperCase 
                                ? this.formData.jurusan_id.toUpperCase() 
                                : this.formData.jurusan_id;
                        }
                    }">
                        <div class="max-w-md mx-auto">
                            <form action="{{ url('jurusan') }}" 
                                  method="post" 
                                  enctype="multipart/form-data" 
                                  @submit.prevent="isSubmitting = true; $el.submit()"
                                  class="space-y-6">
                                @csrf

                                <div class="space-y-2">
                                    <label for="jurusan_id" class="block text-sm font-medium text-gray-700">
                                        Nama Jurusan <span class="text-gray-500 italic">(singkatan)</span>
                                    </label>
                                    
                                    <div class="relative">
                                        <input type="text" 
                                               x-model="formData.jurusan_id"
                                               @input="formatInput"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('jurusan_id') border-red-500 @enderror"
                                               id="jurusan_id" 
                                               name="jurusan_id"
                                               placeholder="Contoh: PPLG, TJKT, AN"
                                               value="{{ old('jurusan_id') }}">
                                        
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <button type="button" 
                                                    @click="isUpperCase = !isUpperCase; formatInput()"
                                                    class="text-gray-400 hover:text-green-500 focus:outline-none"
                                                    :class="{ 'text-green-500': isUpperCase }">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </button>
                                        </div>
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

                                <div class="pt-4">
                                    <button type="submit" 
                                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out"
                                            :disabled="isSubmitting"
                                            :class="{'opacity-75 cursor-not-allowed': isSubmitting}">
                                        <span x-show="!isSubmitting">Simpan Jurusan</span>
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