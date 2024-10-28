<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg flex flex-col md:flex-row">

        <!-- Bagian Kiri: Form -->
        <div class="w-full md:w-1/2 mb-4 md:mb-0">
            <form action="{{ url('agenda/' . $agenda->id) }}" method="post" enctype="multipart/form-data" class="space-y-4">
                @method('PUT')
                @csrf

                <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

                <div>
                    <label for="tgl" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm @error('tgl') border-red-500 @enderror" id="tgl" name="tgl" value="{{ old('tgl', $agenda->tgl) }}" style="padding-left: 10px;">
                    @error('tgl')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="mapel_id" class="block text-sm font-medium text-gray-700">Mapel</label>
                    <select class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm @error('mapel_id') border-red-500 @enderror" name="mapel_id" id="mapel_id" style="padding-left: 10px">
                        @foreach ($mapel as $item)
                            <option value="{{ $item->id }}" {{ $agenda->mapel_id == $item->id ? 'selected' : '' }}>{{ $item->mapel_id }}</option>
                        @endforeach
                    </select>
                    @error('mapel_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="aktivitas" class="block text-sm font-medium text-gray-700">Aktivitas</label>
                    <input type="text" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm @error('aktivitas') border-red-500 @enderror" id="aktivitas" name="aktivitas" value="{{ old('aktivitas', $agenda->aktivitas) }}" style="padding-left: 10px;">
                    @error('aktivitas')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jam_msk" class="block text-sm font-medium text-gray-700">Jam Masuk</label>
                    <input type="time" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm @error('jam_msk') border-red-500 @enderror" id="jam_msk" name="jam_msk" value="{{ old('jam_msk', $agenda->jam_msk) }}" style="padding-left: 10px;">
                    @error('jam_msk')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jam_keluar" class="block text-sm font-medium text-gray-700">Jam Keluar</label>
                    <input type="time" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm @error('jam_keluar') border-red-500 @enderror" id="jam_keluar" name="jam_keluar" value="{{ old('jam_keluar', $agenda->jam_keluar) }}" style="padding-left: 10px;">
                    @error('jam_keluar')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                        Update
                    </button>
                </div>
            </form>
        </div>

        <!-- Bagian Kanan: Gambar (optional) -->
        <div class="w-full md:w-1/2 flex justify-center items-center">
            <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Image" class="w-96 h-auto rounded-lg">
        </div>

    </div>
</x-layout>
