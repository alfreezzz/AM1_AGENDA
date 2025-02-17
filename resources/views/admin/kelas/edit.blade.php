<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto pb-8">
            <div class="">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full md:w-1/2 px-8" x-data="{ 
                        formData: {
                            kelas: '{{ $kelas->kelas }}',
                            kelas_id: '{{ $kelas->kelas_id }}',
                            thn_ajaran: '{{ $kelas->thn_ajaran }}'
                        },
                        isSubmitting: false,
                        formatTahunAjaran() {
                            let value = this.formData.thn_ajaran.replace(/\D/g, '');
                            if (value.length >= 4) {
                                const tahun1 = value.substr(0, 4);
                                const tahun2 = String(Number(tahun1) + 1);
                                this.formData.thn_ajaran = `${tahun1}/${tahun2}`;
                            }
                        }
                    }">
                        <div class="max-w-md mx-auto">
                            <form action="{{ url('kelas/' . $kelas->id) }}" 
                                  method="post" 
                                  enctype="multipart/form-data"
                                  @submit.prevent="isSubmitting = true; $el.submit()"
                                  class="space-y-6">
                                @method('PUT')
                                @csrf

                                <!-- Kelas Selection -->
                                <div class="space-y-3">
                                    <label class="text-sm font-medium text-gray-700 block">Tingkat Kelas</label>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach(['X', 'XI', 'XII'] as $tingkat)
                                            <label class="relative flex cursor-pointer items-center rounded-full p-3 ring-2 ring-transparent transition-all hover:ring-green-500"
                                                   :class="{ 'bg-green-50 ring-green-500': formData.kelas === '{{ $tingkat }}' }">
                                                <input type="radio"
                                                       name="kelas"
                                                       value="{{ $tingkat }}"
                                                       x-model="formData.kelas"
                                                       class="sr-only"
                                                       {{ old('kelas', $kelas->kelas) == $tingkat ? 'checked' : '' }}>
                                                <span class="flex items-center justify-center text-sm font-medium"
                                                      :class="{ 'text-green-700': formData.kelas === '{{ $tingkat }}', 'text-gray-900': formData.kelas !== '{{ $tingkat }}' }">
                                                    {{ $tingkat }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('kelas')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Nomor Kelas Input -->
                                <div class="space-y-2">
                                    <label for="kelas_id" class="block text-sm font-medium text-gray-700">
                                        Nomor Kelas
                                    </label>
                                    <div class="relative">
                                        <input type="number" 
                                               x-model="formData.kelas_id"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('kelas_id') border-red-500 @enderror"
                                               id="kelas_id" 
                                               name="kelas_id"
                                               min="1"
                                               placeholder="Contoh: 1, 2, 3"
                                               value="{{ old('kelas_id', $kelas->kelas_id) }}">
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

                                <!-- Tahun Ajaran Input -->
                                <div class="space-y-2">
                                    <label for="thn_ajaran" class="block text-sm font-medium text-gray-700">
                                        Tahun Ajaran <span class="text-gray-500 italic">Format: 2024/2025</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               x-model="formData.thn_ajaran"
                                               @input="formatTahunAjaran"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('thn_ajaran') border-red-500 @enderror"
                                               id="thn_ajaran" 
                                               name="thn_ajaran"
                                               placeholder="YYYY/YYYY"
                                               maxlength="9"
                                               value="{{ old('thn_ajaran', $kelas->thn_ajaran) }}">
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
                                        <span x-show="!isSubmitting">Update Kelas</span>
                                        <span x-show="isSubmitting" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Updating...
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