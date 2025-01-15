<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
<div class="container">
    <h2>Jadwal Pelajaran</h2>

    <a href="{{ url('jadwal_pelajaran/create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>

   

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
                <td>{{ implode(", ", $item->jam_ke) }}</td>
                <td>{{ $item->thn_ajaran }}</td>
                <td>
                    <a href="{{ url('jadwal.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ url('jadwal.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <form action="{{ url('jadwal_pelajaran/' . $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-layout>
