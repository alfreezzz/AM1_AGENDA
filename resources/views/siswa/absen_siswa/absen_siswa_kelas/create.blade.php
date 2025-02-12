<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    @if (Auth::user()->role == 'Sekretaris')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" x-data="{ 
        currentDate: '{{ date('Y-m-d') }}',
        toast: false,
        showToast() {
            this.toast = true;
            setTimeout(() => this.toast = false, 3000);
        }
    }">
        <!-- Toast Notification -->
        <div x-show="toast" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            Data absensi berhasil disimpan
        </div>

        <form action="{{ route('absen_siswa.store') }}" method="post" enctype="multipart/form-data" 
              @submit="showToast()" class="space-y-8">
            @csrf
            
            <!-- Date Input Section -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <label for="tgl" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Absensi</label>
                <input type="date" 
                       class="w-full md:w-64 h-10 px-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-colors duration-200" 
                       id="tgl" 
                       name="tgl" 
                       x-model="currentDate"
                       :min="currentDate" 
                       :max="currentDate">
                @error('tgl')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Attendance Table Section -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-green-500 text-white">
                                <th class="px-6 py-4 text-center w-16">No</th>
                                <th class="px-6 py-4 text-center">Nama Siswa</th>
                                <th class="px-6 py-4">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($data_siswa as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-200"
                                x-data="{ 
                                    status: 'Hadir',
                                    getStatusColor() {
                                        return {
                                            'Hadir': 'bg-green-100 text-green-800',
                                            'Sakit': 'bg-yellow-100 text-yellow-800',
                                            'Izin': 'bg-blue-100 text-blue-800',
                                            'Alpha': 'bg-red-100 text-red-800'
                                        }[this.status]
                                    }
                                }">
                                <td class="px-6 py-4 text-center text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4  text-gray-900">{{ $item->nama_siswa }}</td>
                                <td class="px-6 py-4">
                                    <input type="hidden" name="siswa[{{ $item->id }}][keterangan]" x-model="status">
                                    <div class="flex justify-center space-x-3">
                                        <template x-for="option in ['Hadir', 'Sakit', 'Izin', 'Alpha']">
                                            <button type="button"
                                                    @click="status = status === option ? 'Hadir' : option"
                                                    :class="[
                                                        'px-4 py-2 rounded-full text-sm font-medium transition-all duration-200',
                                                        status === option ? getStatusColor() : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                                                    ]"
                                                    x-text="option">
                                            </button>
                                        </template>
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
                <button type="submit" 
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Simpan Absensi</span>
                </button>
            </div>
        </form>
    </div>
    @elseif (Auth::user()->role == 'Admin' || Auth::user()->role == 'Guru')
        <div class="min-h-screen flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <p class="text-lg text-gray-700">Anda tidak memiliki hak untuk mengakses halaman ini.</p>
            </div>
        </div>
    @endif
</x-layout>