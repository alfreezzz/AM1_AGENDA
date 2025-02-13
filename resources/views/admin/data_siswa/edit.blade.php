<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto pb-8">
            <!-- Card Container -->
            <div class="">
                <div class="flex flex-col md:flex-row">
                    <!-- Form Section -->
                    <div class="w-full md:w-1/2 px-8">
                        <form action="{{ url('data_siswa/' . $data_siswa->id) }}" method="post" enctype="multipart/form-data" class="space-y-6">
                            @method('PUT')
                            @csrf

                            <div class="space-y-2">
                                <label for="kelas_id" class="text-sm font-medium text-gray-900">Kelas</label>
                                <select class="w-full rounded-lg border-gray-200 bg-gray-50 p-3 text-sm focus:border-green-500 focus:ring-green-500 @error('kelas_id') border-red-500 @enderror" name="kelas_id" id="kelas_id">
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}" {{ $data_siswa->kelas_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }} ({{ $item->thn_ajaran }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="nama_siswa" class="text-sm font-medium text-gray-900">Nama Siswa</label>
                                <input type="text" class="w-full rounded-lg border-gray-200 bg-gray-50 p-3 text-sm focus:border-green-500 focus:ring-green-500 @error('nama_siswa') border-red-500 @enderror" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa', $data_siswa->nama_siswa) }}" placeholder="Masukkan nama lengkap">
                                @error('nama_siswa')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="nis_id" class="text-sm font-medium text-gray-900">NIS</label>
                                <input type="number" class="w-full rounded-lg border-gray-200 bg-gray-50 p-3 text-sm focus:border-green-500 focus:ring-green-500 @error('nis_id') border-red-500 @enderror" id="nis_id" name="nis_id" value="{{ old('nis_id', $data_siswa->nis_id) }}" placeholder="Masukkan NIS">
                                @error('nis_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-900">Gender</label>
                                <div class="flex space-x-6">
                                    <div class="flex items-center">
                                        <input type="radio" id="gender_pria" name="gender" value="Pria" {{ old('gender', $data_siswa->gender) == 'Pria' ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-green-500 focus:ring-green-500">
                                        <label for="gender_pria" class="ml-2 flex items-center text-sm text-gray-700">
                                            <span class="text-blue-500 text-lg mr-1">&#9794;</span> Laki-laki
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="gender_wanita" name="gender" value="Wanita" {{ old('gender', $data_siswa->gender) == 'Wanita' ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-green-500 focus:ring-green-500">
                                        <label for="gender_wanita" class="ml-2 flex items-center text-sm text-gray-700">
                                            <span class="text-pink-500 text-lg mr-1">&#9792;</span> Perempuan
                                        </label>
                                    </div>
                                </div>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-green-500 px-5 py-3 text-sm font-medium text-white hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-300 transition duration-200">
                                    Update Data Siswa
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Image Section -->
                    <div class="w-full md:w-1/2 px-8 flex items-center justify-center">
                        <div class="relative">
                            <div class="absolute -inset-4">
                                <div class="w-full h-full mx-auto"></div>
                            </div>
                            <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Image" class="relative w-80 h-aut">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>