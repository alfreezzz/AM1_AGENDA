<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>

    <div class="container mx-auto p-6 flex flex-col md:flex-row">
        <div class="w-full md:w-1/2 mb-4 md:mb-0">
            <form action="{{ url('user/' . $user->id) }}" method="post" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <div class="mt-2 flex items-center space-x-4">
                        <div>
                            <input type="radio" id="role_admin" name="role" value="Admin" {{ old('role', $user->role) == 'Admin' ? 'checked' : '' }} class="text-green-500 focus:ring-green-500">
                            <label for="role_admin" class="text-sm text-gray-700">
                                <i class="fas fa-user-shield mr-2"></i> Admin
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="role_guru" name="role" value="Guru" {{ old('role', $user->role) == 'Guru' ? 'checked' : '' }} class="text-green-500 focus:ring-green-500">
                            <label for="role_guru" class="text-sm text-gray-700">
                                <i class="fas fa-chalkboard-teacher mr-2"></i> Guru
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="role_perwakilan_kelas" name="role" value="Sekretaris" {{ old('role', $user->role) == 'Sekretaris' ? 'checked' : '' }} class="text-green-500 focus:ring-green-500">
                            <label for="role_perwakilan_kelas" class="text-sm text-gray-700">
                                <i class="fas fa-users mr-2"></i> Sekretaris
                            </label>
                        </div>
                    </div>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="kode-guru-section" style="display: none;">
                    <label for="mata_pelajaran" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                    <div class="mt-2 space-y-2">
                        @foreach($mapel as $item)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="mapel_ids[]" value="{{ $item->id }}" 
                                    class="text-green-500 focus:ring-green-500"
                                    {{ in_array($item->id, $user->mapels->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <span>{{ $item->nama_mapel }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('mapel_ids')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <label for="kelas" class="block text-sm font-medium text-gray-700 mt-3">Kelas Mengajar</label>
                    <div class="mt-2 space-y-2">
                        @foreach($kelas as $item)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="kelas_ids[]" value="{{ $item->id }}" 
                                    class="text-green-500 focus:ring-green-500"
                                    {{ in_array($item->id, $user->dataKelas->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <span>{{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }} ({{ $item->thn_ajaran }})</span>
                            </label>
                        @endforeach
                    </div>
                    @error('kelas_ids')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> 

                <!-- Dropdown Kelas -->
                <div id="kelas-section" style="display: none;">
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <select class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('kelas_id') border-red-500 @enderror" name="kelas_id" id="kelas_id" style="padding-left: 10px;">
                        <option value="">--Pilih--</option>
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}" {{ old('kelas_id', $user->kelas_id) == $item->id ? 'selected' : '' }}>{{ $item->kelas }} {{ $item->jurusan->jurusan_id }} {{ $item->kelas_id }} ({{ $item->thn_ajaran }})</option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" style="padding-left: 10px;">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input type="password" class="mt-1 block w-full h-10 bg-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 sm:text-sm @error('password') border-red-500 @enderror" id="password" name="password" value="{{ old('password') }}" placeholder="Kosongkan jika tidak ingin mengganti" style="padding-left: 10px;">
                        
                        <!-- Eye Icon -->
                        <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility('password', 'togglePasswordIcon')">
                            <i id="togglePasswordIcon" class="fas fa-eye text-gray-600"></i>
                        </span>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Update</button>
            </form>
        </div>
        <!-- Bagian Kanan: Gambar -->
        <div class="w-full md:w-1/2 flex justify-center items-center">
            <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Image" class="w-72 h-auto rounded-lg">
        </div>
    </div>

    <!-- Tambahkan script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleInputs = document.querySelectorAll('input[name="role"]');
            const kelasSection = document.getElementById('kelas-section');

            roleInputs.forEach(roleInput => {
                roleInput.addEventListener('change', function() {
                    if (this.value === 'Sekretaris') {
                        kelasSection.style.display = 'block';
                    } else {
                        kelasSection.style.display = 'none';
                    }
                });
            });

            // Pastikan kelas select muncul jika role 'Sekretaris' sudah dipilih pada awal load
            const checkedRole = document.querySelector('input[name="role"]:checked');
            if (checkedRole && checkedRole.value === 'Sekretaris') {
                kelasSection.style.display = 'block';
            }
        });

        function togglePasswordVisibility(passwordFieldId, iconId) {
            const passwordField = document.getElementById(passwordFieldId);
            const toggleIcon = document.getElementById(iconId);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const roleInputs = document.querySelectorAll('input[name="role"]');
            const kelasSection = document.getElementById('kelas-section');
            const kodeGuruSection = document.getElementById('kode-guru-section');

            roleInputs.forEach(roleInput => {
                roleInput.addEventListener('change', function() {
                    if (this.value === 'Sekretaris') {
                        kelasSection.style.display = 'block';
                        kodeGuruSection.style.display = 'none';
                    } else if (this.value === 'Guru') {
                        kodeGuruSection.style.display = 'block';
                        kelasSection.style.display = 'none';
                    } else {
                        kelasSection.style.display = 'none';
                        kodeGuruSection.style.display = 'none';
                    }
                });
            });

            // Pastikan dropdown tampil jika 'Sekretaris' atau 'Guru' sudah dipilih
            const checkedRole = document.querySelector('input[name="role"]:checked');
            if (checkedRole && checkedRole.value === 'Sekretaris') {
                kelasSection.style.display = 'block';
            } else if (checkedRole && checkedRole.value === 'Guru') {
                kodeGuruSection.style.display = 'block';
            }
        });

    </script>
</x-layout>
