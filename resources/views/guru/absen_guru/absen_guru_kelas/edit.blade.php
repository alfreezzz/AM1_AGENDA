<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="container mx-auto p-6 flex flex-col md:flex-row">
        <!-- Bagian Kiri: Form -->
        <div class="w-full md:w-1/2 mb-4 md:mb-0">
            <form action="{{ url('absen_guru/' . $absen_guru->id) }}" method="post" enctype="multipart/form-data" class="space-y-4">
                @method('PUT')
                @csrf

                <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

                <!-- Mapel (Tidak Bisa Diedit) -->
                <div class="form-group">
                    <label for="mapel_nama" class="block text-sm font-medium text-gray-700">Mapel</label>
                    <input type="text" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm sm:text-sm" 
                        id="mapel_nama" value="{{ $absen_guru->mapel->nama_mapel }}" disabled style="padding-left: 10px;">
                    <input type="hidden" name="mapel_id" value="{{ $absen_guru->mapel_id }}">
                </div>

                <!-- Tanggal -->
                <div class="form-group">
                    <label for="tgl" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('tgl') border-red-500 @enderror" 
                                id="tgl" name="tgl" value="{{ old('tgl', $absen_guru->tgl) }}" style="padding-left: 10px;" readonly>
                    @error('tgl')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan dengan Flexbox -->
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <div class="flex space-x-4"> <!-- Menggunakan Flex untuk menyusun radio button -->
                        <div class="form-check">
                            <input type="radio" class="form-check-input @error('keterangan') is-invalid @enderror" id="keterangan_sakit" name="keterangan" value="Sakit" {{ old('keterangan', $absen_guru->keterangan) == 'Sakit' ? 'checked' : '' }} onchange="updateMessage()">
                            <label class="form-check-label" for="keterangan_sakit">Sakit</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input @error('keterangan') is-invalid @enderror" id="keterangan_izin" name="keterangan" value="Izin" {{ old('keterangan', $absen_guru->keterangan) == 'Izin' ? 'checked' : '' }} onchange="updateMessage()">
                            <label class="form-check-label" for="keterangan_izin">Izin</label>
                        </div>
                    </div>
                    @error('keterangan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Upload Tugas Berupa Gambar -->
                <div class="form-group">
                    <label for="tugas" class="block text-sm font-medium text-gray-700">Tugas</label>
                    <label class="flex w-full cursor-pointer" style="margin: 10px; margin-left: 0;">
                        <span class="bg-green-500 text-white py-2 px-4 rounded-lg flex items-center justify-center hover:bg-green-600 transition-all duration-200">
                            <img src="{{ asset('assets/images/upload-regular-24.png') }}" alt="Upload Icon" class="w-6 h-6 mr-2">
                            <span>Tambah Tugas</span>
                        </span>
                        <input type="file" class="hidden" id="tugas" name="tugas[]" multiple>
                    </label>
                    @error('tugas')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="keterangantugas" class="block text-sm font-medium text-gray-700">Keterangan Tugas</label>
                    <input type="text" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('keterangantugas') border-red-500 @enderror" id="keterangantugas" name="keterangantugas" value="{{ old('keterangantugas', $absen_guru->keterangantugas) }}" style="padding-left: 10px;">
                    @error('keterangantugas')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">Update</button>
            </form>
        </div>

        <!-- Bagian Kanan: Gambar dan Pesan -->
        <div class="w-full md:w-1/2 flex justify-center items-center">
            <div class="text-center">
                <!-- Gambar Responsif dan Mengecil di Desktop -->
                <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Image" class="w-full max-w-xs md:max-w-sm lg:max-w-xs xl:max-w-xs h-auto mb-4"> <!-- Gambar lebih kecil di Desktop -->
                <div id="message" class="text-lg font-bold text-green-600">
                    <!-- Default message or dynamic message will appear here -->
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Mengubah Pesan -->
    <script>
        function updateMessage() {
            const sakit = document.getElementById('keterangan_sakit').checked;
            const izin = document.getElementById('keterangan_izin').checked;
            const messageDiv = document.getElementById('message');

            if (sakit) {
                messageDiv.textContent = 'Semoga lekas sembuh';
            } else if (izin) {
                messageDiv.textContent = 'Semoga urusanmu lancar';
            } else {
                messageDiv.textContent = '';
            }
        }
    </script>
</x-layout>
