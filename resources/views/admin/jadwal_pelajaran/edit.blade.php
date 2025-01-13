@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Jadwal Pelajaran</h2>

   <!-- Bagian Kiri: Form -->
   <div class="w-full md:w-1/2 mb-4 md:mb-0">
            <form action="{{ url('jadwal_pelajaran/' . $jadwal_pelajaran->id) }}" method="post" enctype="multipart/form-data" class="space-y-4">
                @method('PUT')
                @csrf

        <div class="mb-3">
            <label for="hari" class="form-label">Hari</label>
            <select name="hari" id="hari" class="form-control">
                <option value="Senin" {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                <option value="Selasa" {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="Rabu" {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="Kamis" {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="Jumat" {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                <option value="Sabtu" {{ $jadwal->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jam_ke" class="form-label">Jam Ke</label>
            <select name="jam_ke[]" id="jam_ke" class="form-control" multiple>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ in_array($i, $jadwal->jam_ke) ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            <small class="form-text text-muted">Tekan CTRL atau CMD untuk memilih lebih dari satu jam pelajaran.</small>
        </div>

        <div class="mb-3">
            <label for="kelas_id" class="form-label">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="form-control">
                @foreach($kelas as $item)
                    <option value="{{ $item->id }}" {{ $jadwal->kelas_id == $item->id ? 'selected' : '' }}>{{ $item->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="mapel_id" class="form-label">Mata Pelajaran</label>
            <select name="mapel_id" id="mapel_id" class="form-control">
                @foreach($mapel as $item)
                    <option value="{{ $item->id }}" {{ $jadwal->mapel_id == $item->id ? 'selected' : '' }}>{{ $item->nama_mapel }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="guru_id" class="form-label">Guru</label>
            <select name="guru_id" id="guru_id" class="form-control">
                @foreach($guru as $item)
                    <option value="{{ $item->id }}" {{ $jadwal->guru_id == $item->id ? 'selected' : '' }}>{{ $item->nama_guru }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="thn_ajaran" class="form-label">Tahun Ajaran</label>
            <input type="text" name="thn_ajaran" id="thn_ajaran" class="form-control" value="{{ $jadwal->thn_ajaran }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection