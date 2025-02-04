<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    @if (Auth::user()->role == 'Sekretaris')
    <form action="{{ route('absen_siswa.store') }}" method="post" enctype="multipart/form-data">
        @csrf
    
        <div class="form-group">
            <label for="tgl" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('tgl') border-red-500 @enderror" 
                            id="tgl" name="tgl" value="{{ old('tgl', date('Y-m-d')) }}" 
                            min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" style="padding-left: 10px;">
            @error('tgl')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    
        <div class="overflow-y-auto max-h-80">
            <table class="min-w-full bg-white border-collapse border border-gray-300 rounded-lg table-auto">
                <thead class="sticky top-0 bg-green-500 text-white">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Nama Siswa</th>
                        <th class="px-4 py-2">Keterangan <i>(Kosongkan Jika Hadir)</i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_siswa as $item)
                        <tr class="text-center border-t">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-left">{{ $item->nama_siswa }}</td>
                            <td class="px-4 py-2">
                                <!-- Hidden input with default value 'Hadir' -->
                                <input type="hidden" name="siswa[{{ $item->id }}][keterangan]" value="Hadir">
    
                                <div class="flex justify-center space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio text-green-500" name="siswa[{{ $item->id }}][keterangan]" value="Sakit" onclick="toggleRadio(this)">
                                        <span class="ml-2">Sakit</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio text-green-500" name="siswa[{{ $item->id }}][keterangan]" value="Izin" onclick="toggleRadio(this)">
                                        <span class="ml-2">Izin</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio text-green-500" name="siswa[{{ $item->id }}][keterangan]" value="Alpha" onclick="toggleRadio(this)">
                                        <span class="ml-2">Alpha</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <div class="mt-4 flex justify-end">
            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">Simpan</button>
        </div>
    </form>

    <script>
        function toggleRadio(radio) {
            if (radio.dataset.checked === "true") {
                radio.checked = false;
                radio.dataset.checked = "false";
            } else {
                // Set semua radio lain dalam grup ke "false"
                const radios = document.getElementsByName(radio.name);
                radios.forEach(input => input.dataset.checked = "false");
                
                // Set yang dipilih saat ini ke "true"
                radio.dataset.checked = "true";
            }
        }
    </script>
    @elseif (Auth::user()->role == 'Admin' || Auth::user()->role == 'Guru')
        <p class="text-center mt-4">Anda tidak memiliki hak untuk mengakses halaman ini.</p>
    @endif
</x-layout>
