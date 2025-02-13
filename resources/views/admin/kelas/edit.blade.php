<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto">
            <div class="">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full md:w-1/2 px-8">
                        <form action="{{ url('kelas/' . $kelas->id) }}" method="post" enctype="multipart/form-data" class="space-y-6">
                            @method('PUT')
                            @csrf

                            <!-- Tingkat Kelas -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-900">Tingkat Kelas</label>
                                <div class="grid grid-cols-3 gap-4">
                                    @foreach(['X', 'XI', 'XII'] as $tingkat)
                                        <div class="relative">
                                            <input type="radio" 
                                                id="kelas{{ $tingkat }}" 
                                                name="kelas" 
                                                value="{{ $tingkat }}"
                                                class="peer hidden" 
                                                {{ old('kelas', $kelas->kelas) == $tingkat ? 'checked' : '' }}>
                                            <label for="kelas{{ $tingkat }}" 
                                                class="flex items-center justify-center p-4 text-gray-700 bg-gray-50 border-2 rounded-lg cursor-pointer transition-all duration-200
                                                peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:text-green-600
                                                hover:bg-gray-100">
                                                {{ $tingkat }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('kelas')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Kelas -->
                            <div class="space-y-2">
                                <label for="kelas_id" class="text-sm font-medium text-gray-900">Nomor Kelas</label>
                                <div class="relative">
                                    <input type="number" 
                                        class="w-full rounded-lg border-gray-200 bg-gray-50 p-3 text-sm focus:border-green-500 focus:ring-green-500 @error('kelas_id') border-red-500 @enderror" 
                                        id="kelas_id" 
                                        name="kelas_id" 
                                        value="{{ old('kelas_id', $kelas->kelas_id) }}"
                                        placeholder="Masukkan nomor kelas">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('kelas_id')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tahun Ajaran -->
                            <div class="space-y-2">
                                <label for="thn_ajaran" class="text-sm font-medium text-gray-900">
                                    Tahun Ajaran
                                    <span class="inline-flex items-center ml-1 text-gray-500">
                                        <i>(format: 2024/2025)</i>
                                        <span class="group relative ml-1">
                                            <svg class="w-4 h-4 text-gray-400 hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="hidden group-hover:block absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded whitespace-nowrap">
                                                Gunakan format tahun ajaran: 2024/2025
                                            </span>
                                        </span>
                                    </span>
                                </label>
                                <input type="text" 
                                    class="w-full rounded-lg border-gray-200 bg-gray-50 p-3 text-sm focus:border-green-500 focus:ring-green-500 @error('thn_ajaran') border-red-500 @enderror" 
                                    id="thn_ajaran" 
                                    name="thn_ajaran" 
                                    value="{{ old('thn_ajaran', $kelas->thn_ajaran) }}"
                                    placeholder="2024/2025">
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
                                    Update Kelas
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