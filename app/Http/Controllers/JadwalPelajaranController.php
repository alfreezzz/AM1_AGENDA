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
    public function index(Request $request)
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
        $user = User::all();

        // Pencarian berdasarkan username guru
        $search = $request->input('search');
        $jadwal = JadwalPelajaran::with(['kelas', 'mapel', 'user'])
            ->whereHas('kelas', function ($query) use ($currentAcademicYear) {
                $query->where('thn_ajaran', $currentAcademicYear);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->get();

        return view('admin.jadwal_pelajaran.index', compact('jadwal', 'kelas', 'mapel', 'user'), ['title' => 'Jadwal Pelajaran']);
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
    }n

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
    public function getGuruByKelas($kelas_id)
    {
        $guru = DB::table('guru_kelas')
            ->join('users', 'guru_kelas.user_id', '=', 'users.id')
            ->where('guru_kelas.kelas_id', $kelas_id)
            ->select('users.id', 'users.name')
            ->distinct()
            ->get();

        return response()->json($guru);
    }


    public function getMapelByGuru($guru_id)
    {
        $mapel = DB::table('guru_mapel')
            ->join('mapels', 'guru_mapel.mapel_id', '=', 'mapels.id')
            ->where('guru_mapel.user_id', $guru_id)
            ->select('mapels.id', 'mapels.nama_mapel')
            ->distinct()
            ->get();

        return response()->json($mapel);
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
