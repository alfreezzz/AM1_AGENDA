<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="">
        <div class="max-w-7xl mx-auto lg:px-8 py-8">
            <!-- Header Section -->
            <div class="mb-12">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <!-- Search Form -->
                    <form action="{{ url('jadwal_pelajaran') }}" method="GET" class="flex-1 flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <input 
                                type="search" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Cari guru..." 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                            >
                        </div>
                        <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>
                    </form>

                    <!-- Add Button -->
                    @if(Auth::user()->role == 'Admin')
                    <a href="{{ url('jadwal_pelajaran/create') }}" 
                        class="inline-flex justify-center items-center px-6 py-2.5 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Data
                    </a>
                    @endif
                </div>
            </div>

            <!-- Schedule Section -->
            <div class="space-y-6">
                @php
                    $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                    $groupedByDay = $jadwal->groupBy('hari');
                @endphp

                @foreach ($daysOfWeek as $hari)
                    @if ($groupedByDay->has($hari))
                    <div class="bg-white rounded-lg shadow-sm" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-6 py-4 text-lg font-medium text-gray-900 hover:bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <span class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mr-3">
                                    {{ substr($hari, 0, 1) }}
                                </span>
                                {{ $hari }}
                            </div>
                            <svg class="w-5 h-5 transform transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition class="border-t">
                            @php
                                $jadwalHari = $groupedByDay->get($hari);
                                $groupedByGrade = $jadwalHari->groupBy(fn($item) => $item->kelas->kelas);
                            @endphp

                            @foreach ($groupedByGrade as $grade => $jadwalGrade)
                            <div class="border-b last:border-b-0" x-data="{ openGrade: false }">
                                <button @click="openGrade = !openGrade" class="w-full flex items-center justify-between px-6 py-2 text-gray-700 hover:bg-gray-50">
                                    <span class="font-medium">Kelas {{ $grade }}</span>
                                    <svg class="w-4 h-4 transform transition-transform" :class="{'rotate-180': openGrade}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="openGrade" x-transition class="px-6 py-4">
                                    @php
                                        $groupedByClass = $jadwalGrade->groupBy(fn($item) => $item->kelas->kelas . ' ' . $item->kelas->jurusan->jurusan_id . ' ' . $item->kelas->kelas_id . ' (' . $item->thn_ajaran . ')');
                                    @endphp

                                    @foreach ($groupedByClass as $classInfo => $jadwalClass)
                                    <div class="mb-4 last:mb-0" x-data="{ openClass: false }">
                                        <button @click="openClass = !openClass" class="w-full text-left font-medium text-gray-900 hover:bg-gray-50 px-4 py-2 rounded-lg">
                                            {{ $classInfo }}
                                        </button>
                                        <div x-show="openClass" x-transition class="overflow-x-auto mt-2">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead>
                                                    <tr>
                                                        <th class="px-4 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase">Guru</th>
                                                        <th class="px-4 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase">Mapel</th>
                                                        <th class="px-4 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase">Jam Ke</th>
                                                        @if(Auth::user()->role == 'Admin')
                                                        <th class="px-4 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach ($jadwalClass as $item)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $item->user->name }}</td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $item->mapel->nama_mapel }}</td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                            @php
                                                                $jamKeArray = json_decode($item->jam_ke);
                                                                echo implode(', ', $jamKeArray);
                                                            @endphp
                                                        </td>
                                                        @if(Auth::user()->role == 'Admin')
                                                        <td class="px-4 py-2 whitespace-nowrap text-center text-sm font-medium">
                                                            <a href="{{ url('jadwal_pelajaran/' . $item->id . '/edit') }}" 
                                                                class="inline-flex items-center px-3 py-1.5 bg-amber-500 text-white rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors duration-200 mr-2">
                                                                Edit
                                                            </a>
                                                            <form action="{{ url('jadwal_pelajaran/' . $item->id) }}" method="POST" 
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" 
                                                                class="inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                    class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </td>
                                                        @endif
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
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-layout>