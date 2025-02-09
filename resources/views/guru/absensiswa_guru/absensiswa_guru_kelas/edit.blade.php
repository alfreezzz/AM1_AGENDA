<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <form action="{{ url('absensiswa_guru/'. $absensi->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

        <!-- Mapel (Tidak Bisa Diedit) -->
        <div class="form-group">
            <label for="mapel_nama" class="block text-sm font-medium text-gray-700">Mapel</label>
            <input type="text" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm sm:text-sm" 
                id="mapel_nama" value="{{ $absensi->mapel->nama_mapel }}" disabled style="padding-left: 10px;">
            <input type="hidden" name="mapel_id" value="{{ $absensi->mapel_id }}">
        </div> 

        <div class="form-group">
            <label for="tgl" class="block text-sm font-medium text-gray-700 mt-3">Tanggal</label>
            <input type="date" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('tgl') border-red-500 @enderror" 
                            id="tgl" name="tgl" value="{{ old('tgl', $absensi->tgl) }}" style="padding-left: 10px;" readonly>
            @error('tgl')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="overflow-y-auto max-h-80">
            <table class="min-w-full bg-white border-collapse border border-gray-300 rounded-lg table-auto">
                <thead class="bg-green-500 text-white">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Nama Siswa</th>
                        <th class="px-4 py-2">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center border-t">
                        <td class="px-4 py-2">1</td>
                        <td class="px-4 py-2 text-left">{{ $absensi->data_siswa->nama_siswa }}</td>
                        <td class="px-4 py-2">
                            <div class="flex justify-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-green-500" name="keterangan" value="Hadir" {{ $absensi->keterangan == 'Hadir' ? 'checked' : '' }}>
                                    <span class="ml-2">Hadir</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-green-500" name="keterangan" value="Sakit" {{ $absensi->keterangan == 'Sakit' ? 'checked' : '' }}>
                                    <span class="ml-2">Sakit</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-green-500" name="keterangan" value="Izin" {{ $absensi->keterangan == 'Izin' ? 'checked' : '' }}>
                                    <span class="ml-2">Izin</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-green-500" name="keterangan" value="Alpha" {{ $absensi->keterangan == 'Alpha' ? 'checked' : '' }}>
                                    <span class="ml-2">Alpha</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-end">
            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">Update</button>
        </div>
    </form>

</x-layout>
