<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto">
            <div class="">
                <div class="flex flex-col lg:flex-row">
                    <!-- Form Section -->
                    <div class="w-full lg:w-1/2 px-6 sm:p-8">

                        <form action="{{ url('agenda/' . $agenda->id) }}" method="post" enctype="multipart/form-data"
                            x-data="{ 
                                validateTime: function() {
                                    const masuk = this.$refs.jamMasuk.value;
                                    const keluar = this.$refs.jamKeluar.value;
                                    if (masuk && keluar && masuk >= keluar) {
                                        this.$refs.jamKeluar.setCustomValidity('Jam keluar harus lebih besar dari jam masuk');
                                    } else {
                                        this.$refs.jamKeluar.setCustomValidity('');
                                    }
                                }
                            }"
                            class="space-y-6">
                            @method('PUT')
                            @csrf

                            <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

                            <!-- Grid layout for form fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Tanggal Field -->
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700">Tanggal</label>
                                    <input type="date" name="tgl" 
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('tgl') border-red-500 @enderror"
                                        value="{{ old('tgl', $agenda->tgl) }}" 
                                        readonly>
                                    @error('tgl')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mapel Field -->
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700">Mata Pelajaran</label>
                                    <input type="text" 
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" 
                                        value="{{ $agenda->mapel->nama_mapel }}" 
                                        disabled>
                                    <input type="hidden" name="mapel_id" value="{{ $agenda->mapel_id }}">
                                </div>
                            </div>

                            <!-- Aktivitas Field -->
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700">Aktivitas Pembelajaran</label>
                                <input type="text" name="aktivitas" 
                                    class="w-full px-4 py-3 rounded-lg bg-white border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('aktivitas') border-red-500 @enderror"
                                    value="{{ old('aktivitas', $agenda->aktivitas) }}"
                                    placeholder="Masukkan aktivitas pembelajaran">
                                @error('aktivitas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Time inputs grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Jam Masuk Field -->
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700">Jam Masuk</label>
                                    <div class="relative">
                                        <input type="time" name="jam_msk" 
                                            x-ref="jamMasuk"
                                            @input="validateTime"
                                            class="w-full px-4 py-3 rounded-lg bg-white border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('jam_msk') border-red-500 @enderror"
                                            value="{{ old('jam_msk', $agenda->jam_msk) }}">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('jam_msk')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jam Keluar Field -->
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700">Jam Keluar</label>
                                    <div class="relative">
                                        <input type="time" name="jam_keluar" 
                                            x-ref="jamKeluar"
                                            @input="validateTime"
                                            class="w-full px-4 py-3 rounded-lg bg-white border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('jam_keluar') border-red-500 @enderror"
                                            value="{{ old('jam_keluar', $agenda->jam_keluar) }}">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('jam_keluar')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                    Update Agenda
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Image Section -->
                    <div class="w-full lg:w-1/2 px-6 sm:p-8 flex justify-center items-center">
                        <div class="relative group">
                            <img src="{{ asset('assets/images/hero.png') }}" 
                                alt="Hero Image" 
                                class="w-full max-w-md h-auto">
                            <div class="absolute inset-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>