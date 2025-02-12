<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    @if (Auth::user()->role == 'Sekretaris')
    <div class="max-w-6xl mx-auto px-4" x-data="{ 
        currentDate: new Date().toISOString().split('T')[0],
        toggleAttendance(studentId) {
            return {
                selected: null,
                select(value) {
                    if (this.selected === value) {
                        this.selected = null;
                    } else {
                        this.selected = value;
                    }
                }
            }
        }
    }">
        <form action="{{ route('absen_siswa.store') }}" method="post" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- Date Input Section -->
            <div class="">
                <label for="tgl" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Absensi</label>
                <input 
                    type="date" 
                    id="tgl" 
                    name="tgl" 
                    x-model="currentDate"
                    :min="currentDate"
                    :max="currentDate"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200 bg-gray-50"
                >
                @error('tgl')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Attendance Table Section -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-emerald-600 text-white">
                                <th class="px-6 py-4 text-center w-16">No</th>
                                <th class="px-6 py-4 text-center">Nama Siswa</th>
                                <th class="px-6 py-4 text-center">
                                    <span class="flex items-center justify-center gap-2">
                                        Keterangan
                                        <span class="text-emerald-200 text-sm italic">(Kosongkan Jika Hadir)</span>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($data_siswa as $item)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 text-gray-500 text-center">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-medium">{{ $item->nama_siswa }}</td>
                                <td class="px-6 py-4" x-data="toggleAttendance({{ $item->id }})">
                                    <input type="hidden" name="siswa[{{ $item->id }}][keterangan]" :value="selected || 'Hadir'">
                                    
                                    <div class="flex justify-center gap-6">
                                        <button 
                                            type="button"
                                            @click="select('Sakit')"
                                            :class="{'bg-emerald-100 text-emerald-700 ring-2 ring-emerald-500': selected === 'Sakit'}"
                                            class="px-4 py-2 rounded-full text-sm font-medium hover:bg-emerald-50 transition duration-150"
                                        >
                                            Sakit
                                        </button>
                                        <button 
                                            type="button"
                                            @click="select('Izin')"
                                            :class="{'bg-emerald-100 text-emerald-700 ring-2 ring-emerald-500': selected === 'Izin'}"
                                            class="px-4 py-2 rounded-full text-sm font-medium hover:bg-emerald-50 transition duration-150"
                                        >
                                            Izin
                                        </button>
                                        <button 
                                            type="button"
                                            @click="select('Alpha')"
                                            :class="{'bg-emerald-100 text-emerald-700 ring-2 ring-emerald-500': selected === 'Alpha'}"
                                            class="px-4 py-2 rounded-full text-sm font-medium hover:bg-emerald-50 transition duration-150"
                                        >
                                            Alpha
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-200 transition duration-150 flex items-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>
    @elseif (Auth::user()->role == 'Admin' || Auth::user()->role == 'Guru')
        <div class="min-h-[400px] flex items-center justify-center">
            <div class="text-center p-8 bg-red-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-lg font-medium text-gray-900">Akses Terbatas</p>
                <p class="mt-2 text-gray-600">Anda tidak memiliki hak untuk mengakses halaman ini.</p>
            </div>
        </div>
    @endif
</x-layout>