<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto">
            <!-- Main Content -->
            <div class="overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <!-- Form Section -->
                    <div class="w-full lg:w-1/2 p-6 lg:px-8">
                        <form action="{{ url('mapel/' . $mapel->id) }}" method="post" enctype="multipart/form-data"
                              class="space-y-6"
                              x-data="{ 
                                  nama_mapel: '{{ old('nama_mapel', $mapel->nama_mapel) }}',
                                  isValid: true
                              }"
                              x-on:submit="isValid = nama_mapel.length >= 3">
                            @method('PUT')
                            @csrf

                            <div class="space-y-2">
                                <label for="nama_mapel" 
                                       class="block text-sm font-medium text-gray-700">
                                    Nama Mata Pelajaran
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="nama_mapel"
                                           name="nama_mapel"
                                           x-model="nama_mapel"
                                           class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('nama_mapel') border-red-500 ring-red-500 @enderror"
                                           placeholder="Masukkan nama mata pelajaran">
                                    
                                    <!-- Success Icon -->
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3"
                                         x-show="nama_mapel.length >= 3"
                                         x-transition>
                                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('nama_mapel')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between pt-4">
                                <a href="{{ url()->previous() }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Kembali
                                </a>
                                <button type="submit"
                                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Image Section -->
                    <div class="w-full lg:w-1/2 px-6 lg:px-8 flex items-center justify-center">
                        <div class="relative w-full max-w-md">
                            <img src="{{ asset('assets/images/hero.png') }}" 
                                 alt="Hero Image" 
                                 class="w-full h-auto">
                            <div class="absolute inset-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>