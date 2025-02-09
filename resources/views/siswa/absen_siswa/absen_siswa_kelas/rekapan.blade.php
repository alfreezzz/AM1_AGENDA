<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    @if($absen_siswa->isEmpty())
        <p class="text-center mt-4">Tidak ada data absensi yang ditemukan</p>
    @else
        <div class="mt-4">
            <div class="mt-2 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg table-auto">
                    <thead class="bg-green-500 text-white">
                        <tr class="text-center">
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama Siswa</th>
                            <th class="px-4 py-2">Hadir</th>
                            <th class="px-4 py-2">Sakit</th>
                            <th class="px-4 py-2">Izin</th>
                            <th class="px-4 py-2">Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absen_siswa as $index => $item)
                            <tr class="text-center border-t border-gray-200 hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 text-left">{{ $item->data_siswa->nama_siswa }}</td>
                                <td class="px-4 py-2">{{ $item->total_hadir }}</td>
                                <td class="px-4 py-2">{{ $item->total_sakit }}</td>
                                <td class="px-4 py-2">{{ $item->total_izin }}</td>
                                <td class="px-4 py-2">{{ $item->total_alpha }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</x-layout>
