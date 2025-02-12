<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto">
            <div class="overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full md:w-1/2 px-8">
                        <form action="{{ url('jurusan/' . $jurusan->id) }}" method="post" enctype="multipart/form-data" class="space-y-6">
                            @method('PUT')
                            @csrf

                            <div class="space-y-2">
                                <label for="jurusan_id" class="block text-sm font-medium text-gray-900">
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
                                    <input 
                                        type="text" 
                                        class="w-full rounded-lg border-gray-200 bg-gray-50 p-3 text-sm focus:border-green-500 focus:ring-green-500 transition-colors duration-200 @error('jurusan_id') border-red-500 @enderror" 
                                        id="jurusan_id" 
                                        name="jurusan_id" 
                                        value="{{ old('jurusan_id', $jurusan->jurusan_id) }}"
                                        placeholder="Masukkan singkatan jurusan"
                                    >
                                </div>
                                @error('jurusan_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Jurusan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Image Section -->
                    <div class="w-full md:w-1/2 px-8 flex items-center justify-center">
                        <div class="relative">
                            <div class="absolute -inset-4">
                                <div class="w-full h-full mx-auto"></div>
                            </div>
                            <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Image" class="relative w-80 h-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>