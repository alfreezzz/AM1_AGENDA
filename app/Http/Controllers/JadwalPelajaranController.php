<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalPelajaranController extends Controller
{
    public function index()
    {
        $jadwal = JadwalPelajaran::with(['kelas', 'mapel', 'user'])->get();
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        $user = User::all();

        return view('admin.jadwal_pelajaran.index', compact('jadwal'), ['title' => 'Jadwal Pelajaran']);
    }

    public function create()
    {
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        $user = User::all();
        return view('admin/jadwal_pelajaran/create', compact('kelas', 'mapel', 'user'), ['title' => 'Jadwal Pelajaran']);
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'hari' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:data_gurus,id', // Pastikan menggunakan nama tabel yang benar
            'mapel_id' => 'required|exists:mapel,id',
            'jam_ke' => 'required|array',
            'jam_ke.*' => 'integer|min:1',
            'thn_ajaran' => 'required|string',
        ]);

        // Menyimpan data 'jam_ke' sebagai string (misalnya "1,2,3")
        $validatedData['jam_ke'] = implode(',', $validatedData['jam_ke']);

        // Simpan jadwal pelajaran ke database
        JadwalPelajaran::create($validatedData);

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }



    public function edit($id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        $guru = Data_guru::all();
        $jadwal->jam_ke = explode(',', $jadwal->jam_ke);

        return view('jadwal.edit', compact('jadwal', 'kelas', 'mapel', 'guru'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'hari' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:data_guru,id',
            'mapel_id' => 'required|exists:mapel,id',
            'jam_ke' => 'required|array',
            'jam_ke.*' => 'integer|min:1',
            'thn_ajaran' => 'required|string',
        ]);

        $validatedData['jam_ke'] = implode(',', $validatedData['jam_ke']);

        $jadwal = JadwalPelajaran::findOrFail($id);
        $jadwal->update($validatedData);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
