<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="container mx-auto p-6 flex flex-col md:flex-row">

        <!-- Bagian Kiri: Form -->
        <div class="w-full md:w-1/2 mb-4 md:mb-0">
            <form action="{{ url('mapel/' . $mapel->id) }}" method="post" enctype="multipart/form-data" class="space-y-4">
                @method('PUT')
                @csrf

                <div>
                    <label for="nama_mapel" class="block text-sm font-medium text-gray-700">Nama Mata Pelajaran</label>
                    <input type="text" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-smfocus:outline-none focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('nama_mapel') border-red-500 @enderror" id="nama_mapel" name="nama_mapel" value="{{ old('nama_mapel', $mapel->nama_mapel) }}" style="padding-left: 10px;">
                    @error('nama_mapel')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">Update</button>
                </div>
            </form>
        </div>

        <!-- Bagian Kanan: Gambar -->
        <div class="w-full md:w-1/2 flex justify-center items-center">
            <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Image" class="w-72 h-auto rounded-lg">
        </div>

    </div>
</x-layout>
