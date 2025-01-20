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
        $validatedData = $request->validate([
            'hari' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:users,id',
            'mapel_id' => 'required|exists:mapels,id',
            'jam_ke' => 'required|array',
            'jam_ke.*' => 'integer|min:1',
            'thn_ajaran' => 'required|string',
        ]);
    
        // Konversi array ke JSON
        $validatedData['jam_ke'] = json_encode($validatedData['jam_ke']);
    
        JadwalPelajaran::create($validatedData);
    
        return redirect('jadwal_pelajaran')->with('success', 'Jadwal berhasil ditambahkan');
    }
    

    

    public function edit($id)
    {
        // Ambil data jadwal berdasarkan ID
        $jadwal = JadwalPelajaran::findOrFail($id);
    
        // Ambil data kelas, mapel, dan guru untuk dropdown
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        $user = User::all();
    
        // Konversi 'jam_ke' dari JSON ke array agar checkbox dapat diisi
        $jadwal->jam_ke = json_decode($jadwal->jam_ke, true);
    
        // Tampilkan halaman edit dengan data
        return view('admin.jadwal_pelajaran.edit', compact('jadwal', 'kelas', 'mapel', 'user'), ['title' => 'Edit Jadwal Pelajaran']);
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
    // Ambil data jadwal berdasarkan ID
    $jadwal = JadwalPelajaran::findOrFail($id);

    // Hapus data
    $jadwal->delete();

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
}

}
