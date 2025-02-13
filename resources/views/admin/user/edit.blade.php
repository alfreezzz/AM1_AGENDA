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
                                  showPassword: false 
                              }" 
                              class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Role Selection -->
                            <div class="space-y-4">
                                <label class="text-sm font-semibold text-gray-700">Select Role</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <!-- Admin Role -->
                                    <label class="relative flex items-center p-4 cursor-pointer bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <input type="radio" name="role" value="Admin" 
                                               x-model="role"
                                               class="peer sr-only">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                                                <i class="fas fa-user-shield"></i>
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
                                                <i class="fas fa-chalkboard-teacher"></i>
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
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <span class="ml-3 font-medium text-gray-900">Sekretaris</span>
                                        </div>
                                        <div class="absolute inset-0 rounded-lg ring-2 ring-transparent peer-checked:ring-green-500 transition-all"></div>
                                    </label>
                                </div>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
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
                                            <label class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-md transition-colors">
                                                <input type="checkbox" name="mapel_ids[]" value="{{ $item->id }}" 
                                                       {{ in_array($item->id, $user->mapels->pluck('id')->toArray()) ? 'checked' : '' }}
                                                       class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
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
                                            <label class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-md transition-colors">
                                                <input type="checkbox" name="kelas_ids[]" value="{{ $item->id }}" 
                                                       {{ in_array($item->id, $user->dataKelas->pluck('id')->toArray()) ? 'checked' : '' }}
                                                       class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
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
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Name Field -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
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
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                Update Account
                            </button>
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