<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="container mx-auto p-6 flex flex-col md:flex-row">

        <!-- Bagian Kiri: Form -->
        <div class="w-full md:w-1/2 mb-4 md:mb-0">
            <form action="{{ url('jadwal_pelajaran/' . $jadwal->id) }}" method="post" enctype="multipart/form-data" class="space-y-4">
                @method('PUT')
                @csrf

                <!-- Pilihan Hari -->
                <div>
                    <label for="hari" class="block text-sm font-medium text-gray-700">Hari</label>
                    <select class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('hari') border-red-500 @enderror" name="hari" id="hari" style="padding-left: 10px;">
                        <option value="Senin" {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                        <option value="Sabtu" {{ $jadwal->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                    </select>
                    @error('hari')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilihan Jam Ke -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jam Ke</label>
                    <div class="flex flex-wrap gap-4">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="flex items-center">
                                <input type="checkbox" id="jam_ke_{{ $i }}" name="jam_ke[]" value="{{ $i }}" class="h-4 w-4 text-green-500 focus:ring-green-500" {{ is_array($jadwal->jam_ke) && in_array($i, $jadwal->jam_ke) ? 'checked' : '' }}>
                                <label for="jam_ke_{{ $i }}" class="ml-2 text-sm text-gray-700">Jam {{ $i }}</label>
                            </div>
                        @endfor
                    </div>
                    <small class="block mt-1 text-sm text-gray-500">Pilih jam pelajaran yang sesuai.</small>
                    @error('jam_ke')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilihan Kelas -->
                <div>
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <select class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('kelas_id') border-red-500 @enderror" name="kelas_id" id="kelas_id" style="padding-left: 10px;">
                    @foreach($kelas as $item)
                            <option value="{{ $item->id }}">{{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }} ({{ $item->thn_ajaran }})</option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Pilihan Mata Pelajaran -->
                <div>
                    <label for="mapel_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                    <select class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('mapel_id') border-red-500 @enderror" name="mapel_id" id="mapel_id" style="padding-left: 10px;">
                        @foreach($mapel as $item)
                            <option value="{{ $item->id }}" {{ $jadwal->mapel_id == $item->id ? 'selected' : '' }}>{{ $item->nama_mapel }}</option>
                        @endforeach
                    </select>
                    @error('mapel_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilihan Guru -->
                <div>
                    <label for="guru_id" class="block text-sm font-medium text-gray-700">Guru</label>
                    <select class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('guru_id') border-red-500 @enderror" name="guru_id" id="guru_id" style="padding-left: 10px;">
                        @foreach($user as $item)
                            <option value="{{ $item->id }}" {{ $jadwal->guru_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('guru_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun Ajaran -->
                <div>
                    <label for="thn_ajaran" class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                    <input type="text" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('thn_ajaran') border-red-500 @enderror" id="thn_ajaran" name="thn_ajaran" style="padding-left: 10px;" value="{{ $jadwal->thn_ajaran }}">
                    @error('thn_ajaran')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Simpan -->
                <div>
                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">Simpan Perubahan</button>
                </div>
            </form>
        </div>

        <!-- Bagian Kanan: Gambar -->
        <div class="w-full md:w-1/2 flex justify-center items-center">
            <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Image" class="w-72 h-auto rounded-lg">
        </div>

    </div>
</x-layout>
