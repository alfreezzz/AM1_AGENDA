<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container pb-8 mx-auto">
            <div class="">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full px-8 md:w-1/2" x-data="{ 
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
                                    <label class="block text-sm font-medium text-gray-700">Tingkat Kelas</label>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach(['X', 'XI', 'XII'] as $tingkat)
                                            <label class="relative flex items-center p-3 transition-all rounded-full cursor-pointer ring-2 ring-transparent hover:ring-green-500"
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
                                        <p class="flex items-center mt-2 text-sm text-red-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Nomor Kelas Input -->
                                <div class="space-y-2">
                                    <label for="kelas_id" class="block text-sm font-medium text-gray-700">
                                        Nomor Kelas <span class="italic text-gray-500">(boleh dikosongkan)</span>
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
                                        <p class="flex items-center mt-2 text-sm text-red-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Tahun Ajaran Input -->
                                <div class="space-y-2">
                                    <label for="thn_ajaran" class="block text-sm font-medium text-gray-700">
                                        Tahun Ajaran <span class="italic text-gray-500">Format: 2024/2025</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                           class="w-full px-4 py-3 bg-gray-100 border-transparent rounded-lg focus:border-gray-500 focus:bg-white focus:ring-0" 
                                           value="{{ $kelas->thn_ajaran }}" 
                                           disabled>
                                        <input type="hidden" name="thn_ajaran" value="{{ $kelas->thn_ajaran }}">
                                    </div>
                                    @error('thn_ajaran')
                                        <p class="flex items-center mt-2 text-sm text-red-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-4">
                                    <button type="submit" 
                                            class="flex justify-center w-full px-4 py-3 text-sm font-medium text-white transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                            :disabled="isSubmitting"
                                            :class="{'opacity-75 cursor-not-allowed': isSubmitting}">
                                        <span x-show="!isSubmitting">Update Kelas</span>
                                        <span x-show="isSubmitting" class="flex items-center">
                                            <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
                    <div class="flex items-center justify-center w-full px-8 md:w-1/2">
                        <div class="relative">
                            <div class="absolute inset-0"></div>
                            <img src="{{ asset('assets/images/hero.png') }}" 
                                 alt="Hero Image" 
                                 class="relative z-10 h-auto w-96">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>