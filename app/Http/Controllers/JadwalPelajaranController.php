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
        $currentMonth = date('m');
        $currentYear = date('Y');

        if ($currentMonth >= 7) {
            $currentAcademicYear = $currentYear . '/' . ($currentYear + 1);
        } else {
            $currentAcademicYear = ($currentYear - 1) . '/' . $currentYear;
        }

        // Ambil data kelas untuk tahun ajaran sekarang
        $kelas = Kelas::where('thn_ajaran', $currentAcademicYear)
            ->orderByRaw("FIELD(kelas, 'X', 'XI', 'XII')")
            ->orderBy('kelas_id', 'asc')
            ->get();

        $mapel = Mapel::all();
        $user = User::where('role', 'Guru')->get();
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

        $validatedData['jam_ke'] = json_encode($validatedData['jam_ke']);
        JadwalPelajaran::create($validatedData);

        return redirect('jadwal_pelajaran')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);
        $currentMonth = date('m');
        $currentYear = date('Y');

        if ($currentMonth >= 7) {
            $currentAcademicYear = $currentYear . '/' . ($currentYear + 1);
        } else {
            $currentAcademicYear = ($currentYear - 1) . '/' . $currentYear;
        }

        // Ambil data kelas untuk tahun ajaran sekarang
        $kelas = Kelas::where('thn_ajaran', $currentAcademicYear)
            ->orderByRaw("FIELD(kelas, 'X', 'XI', 'XII')")
            ->orderBy('kelas_id', 'asc')
            ->get();
        $mapel = Mapel::all();
        $user = User::where('role', 'Guru')->get();

        $jadwal->jam_ke = json_decode($jadwal->jam_ke, true);

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
        $jadwal = JadwalPelajaran::findOrFail($id);
        $jadwal->delete();

        return redirect('jadwal_pelajaran')->with('success', 'Jadwal berhasil dihapus');
    }
}
