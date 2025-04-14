<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="">
        <div class="max-w-7xl mx-auto lg:px-8 py-8">
            @if(session('success'))
                <div class="bg-gradient-to-r from-gray-700 to-gray-900 border-b border-gray-900 text-[#C7EEFF] text-center p-4 rounded-lg mb-4">
                    <h1 class="text-sm sm:text-lg font-bold tracking-wide text-white text-center drop-shadow-lg hover:scale-105 transition-transform duration-300">{{ session('success') }}</h1>
                </div>
            @endif
            <!-- Header Section -->
            <div class="mb-12">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <!-- Search Form -->
                    <form action="{{ url('jadwal_pelajaran') }}" method="GET" 
                        class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
                        <div class="relative flex-grow">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Cari Guru..."
                                    class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" />
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-400 hover:text-green-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Add Button -->
                    @if(Auth::user()->role == 'Admin')
                  <x-btn-add  href="{{ url('jadwal_pelajaran/create') }}" >Tambah Jadwal</x-btn-add>
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
                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center">{{ $item->mapel->nama_mapel }}</td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center">
                                                            @php
                                                                $jamKeArray = json_decode($item->jam_ke);
                                                                echo implode(', ', $jamKeArray);
                                                            @endphp
                                                        </td>
                                                        @if(Auth::user()->role == 'Admin')
                                                        <td class="px-4 py-2 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                                           <x-btn-edit  href="{{ url('jadwal_pelajaran/' . $item->id . '/edit') }}" ></x-btn-edit>
                                                            <x-btn-delete  action="{{ url('jadwal_pelajaran/' . $item->id) }}"></x-btn-delete>
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