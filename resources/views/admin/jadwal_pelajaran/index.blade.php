<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
<div class="container">
    <h2>Jadwal Pelajaran</h2>

    <a href="{{ url('jadwal.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>

    

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <th>Jam Ke</th>
                <th>Tahun Ajaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal as $item)
            <tr>
                <td>{{ $item->hari }}</td>
                <td>{{ $item->kelas->nama_kelas }}</td>
                <td>{{ $item->mapel->nama_mapel }}</td>
                <td>{{ $item->guru->nama_guru }}</td>
                <td>{{ implode(", ", $item->jam_ke) }}</td>
                <td>{{ $item->thn_ajaran }}</td>
                <td>
                    <a href="{{ url('jadwal.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ url('jadwal.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-layout>
