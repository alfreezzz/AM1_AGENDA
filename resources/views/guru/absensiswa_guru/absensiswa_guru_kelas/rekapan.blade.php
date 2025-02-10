<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    @if($absensiswa_guru->isEmpty())
        <p class="text-center mt-4">Tidak ada data absensi yang ditemukan</p>
    @else
        <div class="mt-4">
            <div class="mt-2">
                @php
                    $groupedData = $absensiswa_guru->groupBy('user.name');
                @endphp

                @foreach ($groupedData as $guru_nama => $mapelData)
                    @if(Auth::user()->role == 'Admin')
                        <h3 class="text-lg font-medium mb-2 mt-2 text-blue-600">Guru: {{ $guru_nama ?? 'Tidak Diketahui' }}</h2>
                    @endif

                    @php
                        $mapelGrouped = $mapelData->groupBy('mapel.nama_mapel');
                    @endphp

                    @foreach ($mapelGrouped as $mapel_nama => $absensi)
                        <h4 class="text-md font-medium mb-2 mt-2 text-gray-700">Mata Pelajaran: {{ $mapel_nama ?? 'Tidak Diketahui' }}</h3>

                        <table class="overflow-x-auto min-w-full bg-white border border-gray-300 rounded-lg table-auto mt-2">
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
                                @foreach ($absensi as $index => $item)
                                    <tr class="text-center border-t border-gray-200 hover:bg-gray-100">
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 text-left">{{ $item->data_siswa->nama_siswa ?? 'Tidak Diketahui' }}</td>
                                        <td class="px-4 py-2">{{ $item->total_hadir }}</td>
                                        <td class="px-4 py-2">{{ $item->total_sakit }}</td>
                                        <td class="px-4 py-2">{{ $item->total_izin }}</td>
                                        <td class="px-4 py-2">{{ $item->total_alpha }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                @endforeach
            </div>
        </div>
    @endif
</x-layout>
