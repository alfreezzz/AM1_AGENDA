<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $validatedData = $request->validate([
            'hari' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:users,id',
            'mapel_id' => 'required|exists:mapels,id',
            'jam_ke' => 'required|array',
            'jam_ke.*' => 'integer|min:1',
            'thn_ajaran' => 'required|string',
        ]);
<<<<<<< HEAD
    
        $validatedData['jam_ke'] = json_encode($validatedData['jam_ke']);
=======

        // Konversi array ke JSON
        $validatedData['jam_ke'] = json_encode($validatedData['jam_ke']);

>>>>>>> 0c05d5382c14b1f903406cd0b436d7913c3cf44c
        JadwalPelajaran::create($validatedData);

        return redirect('jadwal_pelajaran')->with('success', 'Jadwal berhasil ditambahkan');
    }
<<<<<<< HEAD
=======



>>>>>>> 0c05d5382c14b1f903406cd0b436d7913c3cf44c

    public function edit($id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);
<<<<<<< HEAD
=======

        // Ambil data kelas, mapel, dan guru untuk dropdown
>>>>>>> 0c05d5382c14b1f903406cd0b436d7913c3cf44c
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        $user = User::all();

<<<<<<< HEAD
        $jadwal->jam_ke = json_decode($jadwal->jam_ke, true);
    
=======
        // Konversi 'jam_ke' dari JSON ke array agar checkbox dapat diisi
        $jadwal->jam_ke = json_decode($jadwal->jam_ke, true);

        // Tampilkan halaman edit dengan data
>>>>>>> 0c05d5382c14b1f903406cd0b436d7913c3cf44c
        return view('admin.jadwal_pelajaran.edit', compact('jadwal', 'kelas', 'mapel', 'user'), ['title' => 'Edit Jadwal Pelajaran']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|integer',
            'jam_ke' => 'required|array',
            'hari' => 'required|string',
            'mapel_id' => 'required|integer',
            'guru_id' => 'required|integer',
            'thn_ajaran' => 'required|string',
        ]);

        $validated['jam_ke'] = json_encode($request->jam_ke);
        DB::table('jadwal_pelajarans')->where('id', $id)->update($validated);

        return redirect('jadwal_pelajaran')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
<<<<<<< HEAD
        $jadwal = JadwalPelajaran::findOrFail($id);
        $jadwal->delete();

        return redirect('jadwal_pelajaran')->with('success', 'Jadwal berhasil dihapus');
=======
        // Ambil data jadwal berdasarkan ID
        $jadwal = JadwalPelajaran::findOrFail($id);

        // Hapus data
        $jadwal->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
>>>>>>> 0c05d5382c14b1f903406cd0b436d7913c3cf44c
    }
}
