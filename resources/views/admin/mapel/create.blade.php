<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto">
            <div class="">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full md:w-1/2 px-8 lg:px-12"
                         x-data="{ 
                            nama_mapel: '', 
                            showSuccess: false,
                            validate() {
                                if (this.nama_mapel.length >= 3) {
                                    this.showSuccess = true;
                                    setTimeout(() => this.showSuccess = false, 3000);
                                }
                            }
                         }">
                        <div class="max-w-md mx-auto">
                            <form action="{{ url('mapel') }}" method="post" enctype="multipart/form-data" 
                                  @submit="validate()" 
                                  class="space-y-6">
                                @csrf

                                <div class="space-y-2">
                                    <label for="nama_mapel" 
                                           class="text-sm font-medium text-gray-700 block">
                                        Nama Mata Pelajaran
                                    </label>
                                    <input type="text" 
                                           id="nama_mapel" 
                                           name="nama_mapel" 
                                           x-model="nama_mapel"
                                           class="block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 bg-gray-50 hover:bg-gray-100 @error('nama_mapel') border-red-500 @enderror"
                                           value="{{ old('nama_mapel') }}"
                                           placeholder="Masukkan nama mata pelajaran">
                                    
                                    @error('nama_mapel')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Success Message -->
                                <div x-show="showSuccess" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 transform scale-90"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                                    <span class="block sm:inline">Data berhasil divalidasi!</span>
                                </div>

                                <button type="submit" 
                                        class="w-full bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transform transition duration-200 hover:scale-[1.02]">
                                    Simpan Mata Pelajaran
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Image Section -->
                    <div class="w-full md:w-1/2 px-8 lg:px-12 flex items-center justify-center">
                        <div class="relative w-full max-w-md">
                            <div class="absolute inset-0"></div>
                            <img src="{{ asset('assets/images/hero.png') }}" 
                                 alt="Hero Image" 
                                 class="relative w-full h-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>