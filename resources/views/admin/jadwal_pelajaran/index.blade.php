<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container mx-auto p-6">

        <div class="flex flex-col md:flex-row md:justify-between items-center mb-6 rounded-lg">
            <!-- Form Pencarian Mapel -->
            <form action="{{ url('jadwal_pelajaran') }}" method="GET" class="flex flex-col md:flex-row md:space-x-4 w-full md:w-auto mb-4 md:mb-0">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari guru..." class="py-2 px-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded mt-2 md:mt-0 transition duration-200">Cari</button>
            </form>

            @if(Auth::user()->role == 'Admin')
            <a href="{{ url('jadwal_pelajaran/create') }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">Tambah Data</a>
            @endif
        </div>

        <div class="mt-6">
            @php
                $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                $groupedByDay = $jadwal->groupBy('hari');
            @endphp

            @foreach ($daysOfWeek as $hari)
                @if ($groupedByDay->has($hari))
                <div class="mb-8 border rounded-lg" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full bg-green-100 py-2 px-4 font-semibold text-green-700 hover:bg-green-200 transition duration-300 text-left">
                        {{ $hari }}
                    </button>
                    <div x-show="open" class="overflow-hidden">
                        @php
                            $jadwalHari = $groupedByDay->get($hari);
                            $groupedByGrade = $jadwalHari->groupBy(fn($item) => $item->kelas->kelas);
                        @endphp

                        @foreach ($groupedByGrade as $grade => $jadwalGrade)
                        <div class="mb-6 border-l-4 border-blue-500 pl-4" x-data="{ open: false }">
                            <button @click="open = !open" class="w-full bg-blue-100 py-2 px-4 font-semibold text-blue-700 hover:bg-blue-200 transition duration-300 text-left">
                                Kelas: {{ $grade }}
                            </button>
                            <div x-show="open" class="overflow-hidden">
                                @php
                                    $groupedByClass = $jadwalGrade->groupBy(fn($item) => $item->kelas->kelas . ' ' . $item->kelas->jurusan->jurusan_id . ' ' . $item->kelas->kelas_id . ' (' . $item->thn_ajaran . ')');
                                @endphp

                                @foreach ($groupedByClass as $classInfo => $jadwalClass)
                                <div class="mb-4 border-l-4 border-gray-500 pl-4" x-data="{ open: false }">
                                    <button @click="open = !open" class="w-full bg-gray-100 py-2 px-4 font-semibold text-gray-700 hover:bg-gray-200 transition duration-300 text-left">
                                        {{ $classInfo }}
                                    </button>
                                    <div x-show="open" class="overflow-hidden">
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-sm text-left border-collapse min-w-max">
                                                <thead class="bg-gray-200">
                                                    <tr class="text-center">
                                                        <th class="px-4 py-2 border border-gray-300">Guru</th>
                                                        <th class="px-4 py-2 border border-gray-300">Mapel</th>
                                                        <th class="px-4 py-2 border border-gray-300">Jam Ke</th>
                                                        @if(Auth::user()->role == 'Admin')
                                                        <th class="px-4 py-2 border border-gray-300 text-center">Aksi</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($jadwalClass as $item)
                                                    <tr>
                                                        <td class="px-4 py-2 border border-gray-300">
                                                            {{ $item->user->name }}
                                                        </td>
                                                        <td class="px-4 py-2 border border-gray-300 text-center">
                                                            {{ $item->mapel->nama_mapel }}
                                                        </td>
                                                        <td class="px-4 py-2 border border-gray-300 text-center">
                                                            @php
                                                                $jamKeArray = json_decode($item->jam_ke);
                                                                echo implode(', ', $jamKeArray);
                                                            @endphp
                                                        </td>
                                                        @if(Auth::user()->role == 'Admin')
                                                        <td class="px-4 py-2 border border-gray-300 text-center">
                                                            <a href="{{ url('jadwal_pelajaran/' . $item->id . '/edit') }}" class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600 transition duration-200">Edit</a>
                                                            <form action="{{ url('jadwal_pelajaran/' . $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 transition duration-200">Delete</button>
                                                            </form>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</x-layout>
