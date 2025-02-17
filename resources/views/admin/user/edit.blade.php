<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="">
        <div class="container mx-auto">
            <div class="">
                <div class="flex flex-col md:flex-row py-8 items-center">
                    <!-- Form Section -->
                    <div class="w-full md:w-3/4 px-8">
                        
                        <form action="{{ url('user/' . $user->id) }}" method="post" enctype="multipart/form-data" 
                              x-data="{ 
                                  role: '{{ old('role', $user->role) }}',
                                  showPassword: false,
                                  isSubmitting: false,
                              }" 
                              class="space-y-6" @submit="isSubmitting = true">
                            @csrf
                            @method('PUT')

                            <!-- Role Selection -->
                            <div class="space-y-4">
                                <label class="text-sm font-semibold text-gray-700">Pilih Role</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <!-- Admin Role -->
                                    <label class="relative flex items-center p-4 cursor-pointer bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <input type="radio" name="role" value="Admin" 
                                               x-model="role"
                                               class="peer sr-only">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <span class="ml-3 font-medium text-gray-900">Admin</span>
                                        </div>
                                        <div class="absolute inset-0 rounded-lg ring-2 ring-transparent peer-checked:ring-green-500 transition-all"></div>
                                    </label>

                                    <!-- Guru Role -->
                                    <label class="relative flex items-center p-4 cursor-pointer bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <input type="radio" name="role" value="Guru" 
                                               x-model="role"
                                               class="peer sr-only">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <path d="M12 14L8 11H16L12 14ZM12 4L18 8.5L12 13L6 8.5L12 4ZM2 9.5V14.5L6 16.5V11.5L2 9.5ZM22 9.5L18 11.5V16.5L22 14.5V9.5ZM12 13V20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <span class="ml-3 font-medium text-gray-900">Guru</span>
                                        </div>
                                        <div class="absolute inset-0 rounded-lg ring-2 ring-transparent peer-checked:ring-green-500 transition-all"></div>
                                    </label>

                                    <!-- Sekretaris Role -->
                                    <label class="relative flex items-center p-4 cursor-pointer bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <input type="radio" name="role" value="Sekretaris" 
                                               x-model="role"
                                               class="peer sr-only">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-purple-100 text-purple-600">
                                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M14 2V8H20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M16 13H8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M16 17H8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M10 9H9H8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <span class="ml-3 font-medium text-gray-900">Sekretaris</span>
                                        </div>
                                        <div class="absolute inset-0 rounded-lg ring-2 ring-transparent peer-checked:ring-green-500 transition-all"></div>
                                    </label>
                                </div>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Guru Specific Fields -->
                            <div x-show="role === 'Guru'" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="space-y-4">
                                <!-- Mata Pelajaran -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="text-sm font-semibold text-gray-700 mb-3 block">Mata Pelajaran</label>
                                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($mapel as $item)
                                            <label class="relative flex items-center space-x-2 p-2 rounded-lg border border-gray-200 hover:border-green-500 cursor-pointer transition-colors">
                                                <input type="checkbox" name="mapel_ids[]" value="{{ $item->id }}" 
                                                       {{ in_array($item->id, $user->mapels->pluck('id')->toArray()) ? 'checked' : '' }}
                                                       class="h-4 w-4 text-green-500 focus:ring-green-500 border border-gray-300 rounded">
                                                <span class="text-sm text-gray-700">{{ $item->nama_mapel }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Kelas Mengajar -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="text-sm font-semibold text-gray-700 mb-3 block">Kelas Mengajar</label>
                                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($kelas as $item)
                                            <label class="relative flex items-center space-x-2 p-2 rounded-lg border border-gray-200 hover:border-green-500 cursor-pointer transition-colors">
                                                <input type="checkbox" name="kelas_ids[]" value="{{ $item->id }}" 
                                                       {{ in_array($item->id, $user->dataKelas->pluck('id')->toArray()) ? 'checked' : '' }}
                                                       class="h-4 w-4 text-green-500 focus:ring-green-500 border border-gray-300 rounded">
                                                <span class="text-sm text-gray-700">
                                                    {{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }} 
                                                    <span class="text-gray-500">({{ $item->thn_ajaran }})</span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Sekretaris Specific Fields -->
                            <div x-show="role === 'Sekretaris'"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Kelas</label>
                                    <select name="kelas_id" 
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                        <option value="">--Pilih--</option>
                                        @foreach ($kelas as $item)
                                            <option value="{{ $item->id }}" {{ old('kelas_id', $user->kelas_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }} 
                                                ({{ $item->thn_ajaran }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Name Field -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Password</label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" 
                                        name="password"
                                        placeholder="Leave empty if no change needed"
                                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                    <button type="button" 
                                            @click="showPassword = !showPassword"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800">
                                        <svg x-show="!showPassword" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <svg x-show="showPassword" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                            <line x1="1" y1="1" x2="23" y2="23"></line>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="pt-4">
                                <button type="submit" 
                                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out"
                                        :disabled="isSubmitting"
                                        :class="{'opacity-75 cursor-not-allowed': isSubmitting}">
                                    <span x-show="!isSubmitting">Update Pengguna</span>
                                    <span x-show="isSubmitting" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Menyimpan...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Image Section -->
                    <div class="w-full md:w-1/2 px-8 lg:px-12 flex items-center justify-center">
                        <img src="{{ asset('assets/images/hero.png') }}" 
                             alt="Hero Image" 
                             class="w-full max-w-md">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>