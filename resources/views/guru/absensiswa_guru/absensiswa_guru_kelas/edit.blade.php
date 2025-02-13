<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto max-w-4xl">
            <div class="overflow-hidden">
                <div class="py-6">

                    <form action="{{ url('absensiswa_guru/'. $absensi->id) }}" method="post" enctype="multipart/form-data"
                        x-data="{ keterangan: '{{ $absensi->keterangan }}' }">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

                        <!-- Form Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Mapel Field -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Mata Pelajaran</label>
                                <div class="relative">
                                    <input type="text" 
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" 
                                        value="{{ $absensi->mapel->nama_mapel }}" 
                                        disabled>
                                    <input type="hidden" name="mapel_id" value="{{ $absensi->mapel_id }}">
                                </div>
                            </div>

                            <!-- Tanggal Field -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" 
                                    class="w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 @error('tgl') border-red-500 @enderror" 
                                    name="tgl" 
                                    value="{{ old('tgl', $absensi->tgl) }}" 
                                    readonly>
                                @error('tgl')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Attendance Table -->
                        <div class="relative overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr class="text-center text-sm font-semibold text-gray-900">
                                        <th scope="col" class="px-4 py-2">No</th>
                                        <th scope="col" class="px-4 py-2">Nama Siswa</th>
                                        <th scope="col" class="px-4 py-2">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-4 py-2 text-center text-sm font-medium text-gray-900">1</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-sm text-gray-900">{{ $absensi->data_siswa->nama_siswa }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            <div class="flex flex-wrap gap-4 justify-center" x-data="{ status: '{{ $absensi->keterangan }}' }">
                                                <label class="relative flex cursor-pointer items-center rounded-full p-3 hover:bg-gray-50"
                                                    :class="{ 'ring-2 ring-green-500 bg-green-50': status === 'Hadir' }">
                                                    <input type="radio" name="keterangan" value="Hadir"
                                                        class="sr-only"
                                                        :checked="status === 'Hadir'"
                                                        @change="status = 'Hadir'">
                                                    <span class="flex items-center space-x-2">
                                                        <span class="h-4 w-4 rounded-full border flex items-center justify-center"
                                                            :class="{ 'border-green-500 bg-green-500': status === 'Hadir' }">
                                                            <span class="h-2 w-2 rounded-full bg-white" x-show="status === 'Hadir'"></span>
                                                        </span>
                                                        <span class="text-sm font-medium text-gray-900">Hadir</span>
                                                    </span>
                                                </label>

                                                <label class="relative flex cursor-pointer items-center rounded-full p-3 hover:bg-gray-50"
                                                    :class="{ 'ring-2 ring-yellow-500 bg-yellow-50': status === 'Sakit' }">
                                                    <input type="radio" name="keterangan" value="Sakit"
                                                        class="sr-only"
                                                        :checked="status === 'Sakit'"
                                                        @change="status = 'Sakit'">
                                                    <span class="flex items-center space-x-2">
                                                        <span class="h-4 w-4 rounded-full border flex items-center justify-center"
                                                            :class="{ 'border-yellow-500 bg-yellow-500': status === 'Sakit' }">
                                                            <span class="h-2 w-2 rounded-full bg-white" x-show="status === 'Sakit'"></span>
                                                        </span>
                                                        <span class="text-sm font-medium text-gray-900">Sakit</span>
                                                    </span>
                                                </label>

                                                <label class="relative flex cursor-pointer items-center rounded-full p-3 hover:bg-gray-50"
                                                    :class="{ 'ring-2 ring-blue-500 bg-blue-50': status === 'Izin' }">
                                                    <input type="radio" name="keterangan" value="Izin"
                                                        class="sr-only"
                                                        :checked="status === 'Izin'"
                                                        @change="status = 'Izin'">
                                                    <span class="flex items-center space-x-2">
                                                        <span class="h-4 w-4 rounded-full border flex items-center justify-center"
                                                            :class="{ 'border-blue-500 bg-blue-500': status === 'Izin' }">
                                                            <span class="h-2 w-2 rounded-full bg-white" x-show="status === 'Izin'"></span>
                                                        </span>
                                                        <span class="text-sm font-medium text-gray-900">Izin</span>
                                                    </span>
                                                </label>

                                                <label class="relative flex cursor-pointer items-center rounded-full p-3 hover:bg-gray-50"
                                                    :class="{ 'ring-2 ring-red-500 bg-red-50': status === 'Alpha' }">
                                                    <input type="radio" name="keterangan" value="Alpha"
                                                        class="sr-only"
                                                        :checked="status === 'Alpha'"
                                                        @change="status = 'Alpha'">
                                                    <span class="flex items-center space-x-2">
                                                        <span class="h-4 w-4 rounded-full border flex items-center justify-center"
                                                            :class="{ 'border-red-500 bg-red-500': status === 'Alpha' }">
                                                            <span class="h-2 w-2 rounded-full bg-white" x-show="status === 'Alpha'"></span>
                                                        </span>
                                                        <span class="text-sm font-medium text-gray-900">Alpha</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                Update Absensi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>