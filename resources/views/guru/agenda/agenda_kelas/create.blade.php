<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto pb-8">
            <div class="">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full md:w-1/2 px-8" x-data="{ 
                        isSubmitting: false,
                        validateTime() {
                            let start = this.$refs.jamMsk.value;
                            let end = this.$refs.jamKeluar.value;
                            if (start && end && start >= end) {
                                this.$refs.jamKeluar.setCustomValidity('Jam keluar harus lebih besar dari jam masuk');
                            } else {
                                this.$refs.jamKeluar.setCustomValidity('');
                            }
                        }
                    }">
                                            
                        <form action="{{ url('agenda') }}" method="post" enctype="multipart/form-data" 
                              class="space-y-6"
                              @submit="isSubmitting = true">
                            @csrf
                            <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

                            <!-- Date Input -->
                            <div class="relative">
                                <label for="tgl" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                <input type="date" 
                                       class="block w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-500 transition duration-200 @error('tgl') border-red-500 @enderror"
                                       id="tgl" 
                                       name="tgl" 
                                       value="{{ old('tgl', date('Y-m-d')) }}"
                                       min="{{ date('Y-m-d') }}" 
                                       max="{{ date('Y-m-d') }}">
                                @error('tgl')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Subject Selection -->
                            <div class="relative">
                                <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                                <select id="mapel_id" 
                                        name="mapel_id" 
                                        class="block w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-500 transition duration-200">
                                    <option value="">--Pilih Mata Pelajaran--</option>
                                    @foreach($mapel as $item)
                                        <option value="{{ $item->id }}" {{ old('mapel_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mapel_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Activity Input -->
                            <div class="relative">
                                <label for="aktivitas" class="block text-sm font-medium text-gray-700 mb-1">Aktivitas</label>
                                <input type="text" 
                                       class="block w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-500 transition duration-200 @error('aktivitas') border-red-500 @enderror"
                                       id="aktivitas" 
                                       name="aktivitas" 
                                       value="{{ old('aktivitas') }}"
                                       placeholder="Masukkan aktivitas">
                                @error('aktivitas')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Time Inputs -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <label for="jam_msk" class="block text-sm font-medium text-gray-700 mb-1">Jam Masuk</label>
                                    <input type="time" 
                                           class="block w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-500 transition duration-200 @error('jam_msk') border-red-500 @enderror"
                                           id="jam_msk" 
                                           name="jam_msk" 
                                           x-ref="jamMsk"
                                           value="{{ old('jam_msk') }}"
                                           @change="validateTime()">
                                    @error('jam_msk')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <label for="jam_keluar" class="block text-sm font-medium text-gray-700 mb-1">Jam Keluar</label>
                                    <input type="time" 
                                           class="block w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-500 transition duration-200 @error('jam_keluar') border-red-500 @enderror"
                                           id="jam_keluar" 
                                           name="jam_keluar" 
                                           x-ref="jamKeluar"
                                           value="{{ old('jam_keluar') }}"
                                           @change="validateTime()">
                                    @error('jam_keluar')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center justify-start">
                                <button type="submit" 
                                        class="px-6 py-3 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200"
                                        :disabled="isSubmitting"
                                        x-html="isSubmitting ? '<svg class=\'animate-spin h-5 w-5 text-white\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\'><circle class=\'opacity-25\' cx=\'12\' cy=\'12\' r=\'10\' stroke=\'currentColor\' stroke-width=\'4\'></circle><path class=\'opacity-75\' fill=\'currentColor\' d=\'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\'></path></svg>' : 'Simpan'">
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Image Section -->
                    <div class="w-full md:w-1/2 px-8 flex items-center justify-center">
                        <div class="relative">
                            <div class="absolute inset-0"></div>
                            <img src="{{ asset('assets/images/hero.png') }}" 
                                 alt="Hero Image" 
                                 class="relative w-full max-w-md h-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>