<x-layout>
    <x-slot:title>Edit Group Mapel: {{ $groupName }}</x-slot:title>

    <h1 class="text-xl font-bold mb-4">Edit Grup Mata Pelajaran: {{ $groupName }}</h1>

    <form method="POST" action="{{ route('mapel.update-group', $groupName) }}">
        @csrf

        <table class="min-w-full bg-white border border-gray-300 rounded-lg table-auto mb-4">
            <thead class="bg-green-500 text-white">
                <tr>
                    <th class="py-3 px-6">#</th>
                    <th class="py-3 px-6">Nama Mapel</th>
                    <th class="py-3 px-6">Kode Mapel</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mapelGroup as $index => $mapel)
                    <tr class="border-t border-gray-200">
                        <td class="py-3 px-6">{{ $index + 1 }}</td>
                        <td class="py-3 px-6">
                            <input 
                                type="text" 
                                name="mapel[{{ $mapel->id }}][nama_mapel]" 
                                value="{{ $mapel->nama_mapel }}" 
                                class="w-full py-2 px-3 border rounded" 
                                required>
                        </td>
                        <td class="py-3 px-6">
                            <input 
                                type="text" 
                                name="mapel[{{ $mapel->id }}][kode_mapel]" 
                                value="{{ $mapel->kode_mapel }}" 
                                class="w-full py-2 px-3 border rounded" 
                                required>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">
            Simpan Perubahan
        </button>
        <a href="{{ route('mapel.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition duration-200">
            Batal
        </a>
    </form>
</x-layout>
