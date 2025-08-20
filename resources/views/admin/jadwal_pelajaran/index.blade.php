<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="">
        <div class="py-8 mx-auto max-w-7xl lg:px-8">
            @if(session('success'))
                <div class="bg-gradient-to-r from-gray-700 to-gray-900 border-b border-gray-900 text-[#C7EEFF] text-center p-4 rounded-lg mb-4">
                    <h1 class="text-sm font-bold tracking-wide text-center text-white transition-transform duration-300 sm:text-lg drop-shadow-lg hover:scale-105">{{ session('success') }}</h1>
                </div>
            @endif
            <!-- Header Section -->
            <div class="mb-12">
                <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center">
                    <!-- Search Form -->
                    <form action="{{ url('jadwal_pelajaran') }}" method="GET" 
                        class="flex flex-col w-full gap-2 sm:w-auto sm:flex-row">
                        <div class="relative flex-grow">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Cari Guru..."
                                    class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" />
                            <button type="submit" class="absolute -translate-y-1/2 right-3 top-1/2">
                                <svg class="w-5 h-5 text-gray-400 transition-colors duration-200 hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            @if($jadwal->isEmpty())
                <div class="p-8 text-center bg-white rounded-lg shadow-sm">
                <svg class="w-16 h-16 mx-auto text-gray-400 fill-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                </svg>

                        
                    <p class="mt-4 text-lg text-gray-600">Data jadwal pelajaran belum ditambahkan.</p>
                </div>
            @else

            <!-- Schedule Section -->
            <div class="space-y-6">
                @php
                    $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                    $groupedByDay = $jadwal->groupBy('hari');
                @endphp

                @foreach ($daysOfWeek as $hari)
                    @if ($groupedByDay->has($hari))
                    <div class="bg-white rounded-lg shadow-sm" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-6 py-4 text-lg font-medium text-gray-900 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center">
                                <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-full bg-emerald-100 text-emerald-600">
                                    {{ substr($hari, 0, 1) }}
                                </span>
                                {{ $hari }}
                            </div>
                            <svg class="w-5 h-5 transition-transform transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <button @click="openGrade = !openGrade" class="flex items-center justify-between w-full px-6 py-2 text-gray-700 hover:bg-gray-50">
                                    <span class="font-medium">Kelas {{ $grade }}</span>
                                    <svg class="w-4 h-4 transition-transform transform" :class="{'rotate-180': openGrade}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="openGrade" x-transition class="px-6 py-4">
                                    @php
                                        $groupedByClass = $jadwalGrade->groupBy(fn($item) => $item->kelas->kelas . ' ' . $item->kelas->jurusan->jurusan_id . ' ' . $item->kelas->kelas_id . ' (' . $item->thn_ajaran . ')');
                                    @endphp

                                    @foreach ($groupedByClass as $classInfo => $jadwalClass)
                                    <div class="mb-4 last:mb-0" x-data="{ openClass: false }">
                                        <button @click="openClass = !openClass" class="w-full px-4 py-2 font-medium text-left text-gray-900 rounded-lg hover:bg-gray-50">
                                            {{ $classInfo }}
                                        </button>
                                        <div x-show="openClass" x-transition class="mt-2 overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead>
                                                    <tr>
                                                        <th class="px-4 py-2 text-xs font-medium text-center text-gray-500 uppercase bg-gray-50">Guru</th>
                                                        <th class="px-4 py-2 text-xs font-medium text-center text-gray-500 uppercase bg-gray-50">Mapel</th>
                                                        <th class="px-4 py-2 text-xs font-medium text-center text-gray-500 uppercase bg-gray-50">Jam Ke</th>
                                                        @if(Auth::user()->role == 'Admin')
                                                        <th class="px-4 py-2 text-xs font-medium tracking-wider text-center text-gray-500 uppercase bg-gray-50">Aksi</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach ($jadwalClass as $item)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-4 py-2 text-sm text-gray-900 whitespace-nowrap">{{ $item->user->name }}</td>
                                                        <td class="px-4 py-2 text-sm text-center text-gray-900 whitespace-nowrap">{{ $item->mapel->nama_mapel }}</td>
                                                        <td class="px-4 py-2 text-sm text-center text-gray-900 whitespace-nowrap">
                                                            @php
                                                                $jamKeArray = json_decode($item->jam_ke);
                                                                echo implode(', ', $jamKeArray);
                                                            @endphp
                                                        </td>
                                                        @if(Auth::user()->role == 'Admin')
                                                        <td class="px-4 py-2 space-x-2 text-sm font-medium text-center whitespace-nowrap">
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
            @endif
        </div>
    </div>
</x-layout>