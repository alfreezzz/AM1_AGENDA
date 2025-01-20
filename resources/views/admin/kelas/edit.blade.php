<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="container mx-auto p-6 flex flex-col md:flex-row">

        <!-- Bagian Kiri: Form -->
        <div class="w-full md:w-1/2 mb-4 md:mb-0">
            <form action="{{ url('kelas/' . $kelas->id) }}" method="post" enctype="multipart/form-data" class="space-y-4">
                @method('PUT')
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kelas</label>
                    <div class="flex space-x-4 mt-2">
                        <div class="flex items-center">
                            <input class="form-radio h-4 w-4 text-green-500 @error('kelas') border-red-500 @enderror" type="radio" name="kelas" id="kelasX" value="X" {{ old('kelas', $kelas->kelas) == 'X' ? 'checked' : '' }}>
                            <label for="kelasX" class="ml-2 text-gray-700">X</label>
                        </div>
                        <div class="flex items-center">
                            <input class="form-radio h-4 w-4 text-green-500 @error('kelas') border-red-500 @enderror" type="radio" name="kelas" id="kelasXI" value="XI" {{ old('kelas', $kelas->kelas) == 'XI' ? 'checked' : '' }}>
                            <label for="kelasXI" class="ml-2 text-gray-700">XI</label>
                        </div>
                        <div class="flex items-center">
                            <input class="form-radio h-4 w-4 text-green-500 @error('kelas') border-red-500 @enderror" type="radio" name="kelas" id="kelasXII" value="XII" {{ old('kelas', $kelas->kelas) == 'XII' ? 'checked' : '' }}>
                            <label for="kelasXII" class="ml-2 text-gray-700">XII</label>
                        </div>
                    </div>
                    @error('kelas')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700">No Kelas</label>
                    <input type="number" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('kelas_id') border-red-500 @enderror" id="kelas_id" name="kelas_id" value="{{ old('kelas_id', $kelas->kelas_id) }}" style="padding-left: 10px;">
                    @error('kelas_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="thn_ajaran" class="block text-sm font-medium text-gray-700">Tahun Ajaran <i>*2024/2025</i></label>
                    <input type="text" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('thn_ajaran') border-red-500 @enderror" id="thn_ajaran" name="thn_ajaran" value="{{ old('thn_ajaran', $kelas->thn_ajaran) }}" style="padding-left: 10px;">
                    @error('thn_ajaran')
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
