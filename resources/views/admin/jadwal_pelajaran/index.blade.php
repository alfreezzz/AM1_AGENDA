<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
<div class="container">
    <h2>Jadwal Pelajaran</h2>

    <a href="{{ url('jadwal_pelajaran/create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>
    <link href="{{ asset('css/jadwal.css') }}" rel="stylesheet">
    <div class="overflow-x-auto">
    <table class="table-auto w-full text-center border-collapse border border-gray-300">
        <thead class="bg-blue-700 text-white">
            <tr>
                <th class="border border-gray-400 p-2">No</th>
                <th class="border border-gray-400 p-2">Waktu</th>
                <th class="border border-gray-400 p-2">Kelas X</th>
                <th class="border border-gray-400 p-2">Kelas XI</th>
                <th class="border border-gray-400 p-2">Kelas XII</th>
            </tr>
        </thead>
        <tbody class="text-sm">
            <!-- Example row -->
            <tr>
                <td class="border border-gray-400 p-2">1</td>
                <td class="border border-gray-400 p-2">07:00 - 08:00</td>
                <td class="border border-gray-400 p-2 bg-yellow-200">Upacara</td>
                <td class="border border-gray-400 p-2 bg-yellow-200">Upacara</td>
                <td class="border border-gray-400 p-2 bg-yellow-200">Upacara</td>
            </tr>
            <tr>
                <td class="border border-gray-400 p-2">2</td>
                <td class="border border-gray-400 p-2">08:15 - 09:15</td>
                <td class="border border-gray-400 p-2">Mapel 1</td>
                <td class="border border-gray-400 p-2">Mapel 2</td>
                <td class="border border-gray-400 p-2">Mapel 3</td>
            </tr>
            <!-- Add more rows as per data -->
        </tbody>
    </table>
</div>



   

    <div class="overflow-x-auto mt-4">
        <div class="max-h-96 md:overflow-y-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="sticky top-0 bg-green-500 text-white">
                    <tr class="text-center">
                        <th class="py-3 px-6">Hari</th>
                        <th class="py-3 px-6">Kelas</th>
                        <th class="py-3 px-6">Guru</th>
                        <th class="py-3 px-6">Jam Ke</th>
                        <th class="py-3 px-6">Tahun Ajaran</th>
                        <th class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
        <tbody>
            @foreach($jadwal as $item)
            <tr>
                <td>{{ $item->hari }}</td>
                <td>{{ $item->kelas->kelas }} {{ $item->kelas->jurusan->jurusan_id }} {{ $item->kelas->kelas_id }} ({{ $item->kelas->thn_ajaran }})</td>
                <td>{{ $item->mapel->nama_mapel }}</td>
                <td>{{ $item->user->name}}</td>
                <td>{{ implode(" ", explode(",", $item->jam_ke)) }}</td>
                <td>{{ $item->thn_ajaran }}</td>
                <td>
                <a href="{{ url('jadwal_pelajaran/' . $item->id . '/edit') }}" class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600 transition duration-200">Edit</a>
                <form action="{{ url('jadwal_pelajaran/' . $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 transition duration-200">Delete</button>

                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-layout>
