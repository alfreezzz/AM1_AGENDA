<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($absensiswa_guru->isEmpty())
            <div class="flex items-center justify-center min-h-[200px] bg-white rounded-xl shadow-md">
                <div class="text-center p-8">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M12 20V4"/>
                    </svg>
                    <p class="text-gray-600 text-lg">Tidak ada data absensi yang ditemukan</p>
                </div>
            </div>
        @else
            <div class="space-y-8">
                @php
                    $groupedData = $absensiswa_guru->groupBy('user.name');
                @endphp

                @foreach ($groupedData as $guru_nama => $mapelData)
                    <div class="overflow-hidden">
                        @if(Auth::user()->role == 'Admin')
                            <div class="bg-blue-500 px-6 py-4 flex items-center space-x-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <h3 class="text-xl font-semibold text-white">
                                    {{ $guru_nama ?? 'Tidak Diketahui' }}
                                </h3>
                            </div>
                        @endif

                        <div class="px-2 space-y-6">
                            @php
                                $mapelGrouped = $mapelData->groupBy('mapel.nama_mapel');
                            @endphp

                            @foreach ($mapelGrouped as $mapel_nama => $absensi)
                                <div class="space-y-4">
                                    <div class="flex items-center space-x-2 text-gray-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <h4 class="text-lg font-medium">{{ $mapel_nama ?? 'Tidak Diketahui' }}</h4>
                                    </div>

                                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead>
                                                <tr class="bg-gradient-to-r from-green-500 to-green-600">
                                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-16">No</th>
                                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Nama Siswa</th>
                                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                                        <div class="flex items-center justify-center space-x-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                            <span>Hadir</span>
                                                        </div>
                                                    </th>
                                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                                        <div class="flex items-center justify-center space-x-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            <span>Sakit</span>
                                                        </div>
                                                    </th>
                                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                                        <div class="flex items-center justify-center space-x-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            <span>Izin</span>
                                                        </div>
                                                    </th>
                                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                                        <div class="flex items-center justify-center space-x-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            <span>Alpha</span>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($absensi as $index => $item)
                                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            {{ $item->data_siswa->nama_siswa ?? 'Tidak Diketahui' }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                {{ $item->total_hadir }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                {{ $item->total_sakit }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ $item->total_izin }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                {{ $item->total_alpha }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>