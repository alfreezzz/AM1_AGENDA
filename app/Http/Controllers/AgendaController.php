<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Agenda;
use App\Models\Kelas;
use App\Models\Mapel;
use DB;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Tentukan awal dan akhir tahun ajaran
        if ($currentMonth >= 7) { // Juli hingga Desember
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        } else { // Januari hingga Juni
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        }

        $currentAcademicYear = "$startYear/$endYear";
        $hariIni = now()->locale('id')->dayName; // Nama hari dalam Bahasa Indonesia

        // Cek apakah admin ingin melihat semua data atau hanya tahun ajaran sekarang
        $showAll = $request->query('show_all', false);

        if (auth()->user()->role === 'Guru') {
            // Guru hanya melihat kelas yang diajarkan
            $kelas = auth()->user()->dataKelas()
                ->where('thn_ajaran', $currentAcademicYear)
                ->with('jurusan')
                ->get();
        } elseif (auth()->user()->role === 'Admin' && $showAll) {
            $kelas = Kelas::with('jurusan')->get(); // Admin dapat melihat semua kelas
        } else {
            $kelas = Kelas::with('jurusan')
                ->where('thn_ajaran', $currentAcademicYear)
                ->get(); // Default untuk admin tanpa `show_all`
        }

        return view('guru.agenda.index', compact('kelas'), [
            'title' => 'Daftar Kelas',
            'currentAcademicYear' => $currentAcademicYear,
        ]);
    }

    public function agendaByClass(Request $request, $slug)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();

        $filter = $request->query('filter');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $agendaQuery = Agenda::where('kelas_id', $kelas->id)
            ->with(['user', 'mapel'])
            ->orderBy('tgl', 'desc');

        if ($filter === 'last_week') {
            $agendaQuery->whereBetween('tgl', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek()
            ]);
        } elseif ($filter === 'last_month') {
            $agendaQuery->whereBetween('tgl', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ]);
        } elseif ($filter === 'range' && $startDate && $endDate) {
            $agendaQuery->whereBetween('tgl', [$startDate, $endDate]);
        }

        if (auth()->user()->role === 'Guru') {
            $user = auth()->user();
            $assignedMapels = Agenda::where('kelas_id', $kelas->id)
                ->where('added_by', $user->id)
                ->pluck('mapel_id');

            $agendaQuery->whereIn('mapel_id', $assignedMapels);
        }

        $agenda = $agendaQuery->get();

        return view(
            'guru.agenda.agenda_kelas.index',
            compact('agenda', 'kelas', 'filter', 'startDate', 'endDate'),
            [
                'title' => 'Agenda Harian Kelas ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    // Ubah fungsi create agar menerima $kelas_id dari route.
    public function create($kelas_id)
    {
        $user = auth()->user(); // Ambil user yang sedang login
        $hariIni = now()->locale('id')->dayName; // Dapatkan nama hari saat ini dalam Bahasa Indonesia

        // Tentukan tahun ajaran saat ini
        $currentMonth = now()->month;
        $currentYear = now()->year;
        if ($currentMonth >= 7) { // Juli hingga Desember
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        } else { // Januari hingga Juni
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        }
        $currentAcademicYear = "$startYear/$endYear";

        $kelas = Kelas::find($kelas_id); // Ambil detail kelas
        $jadwal = DB::table('jadwal_pelajarans')
            ->where('guru_id', $user->id)
            ->where('hari', $hariIni)
            ->where('kelas_id', $kelas_id)
            ->where('thn_ajaran', $currentAcademicYear)
            ->get();

        // Ambil ID mapel dari jadwal yang relevan
        $mapelIds = $jadwal->pluck('mapel_id')->toArray();

        // Ambil hanya mapel yang sesuai dengan jadwal
        $mapel = Mapel::whereIn('id', $mapelIds)->get();

        return view('guru.agenda.agenda_kelas.create', [
            'kelas_id' => $kelas_id,
            'kelas' => $kelas,
            'mapel' => $mapel,
        ], [
            'title' => 'Tambah Agenda Harian Kelas ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl' => [
                'required',
                function ($attribute, $value, $fail) {
                    $date = Carbon::parse($value);
                    if ($date->dayOfWeek == Carbon::SATURDAY || $date->dayOfWeek == Carbon::SUNDAY) {
                        $fail('Tidak dapat menambahkan data pada hari Sabtu atau Minggu.');
                    }
                    if ($value !== Carbon::today()->toDateString()) {
                        $fail('Tanggal harus diisi dengan tanggal hari ini.');
                    }
                },
            ],
            'mapel_id' => 'required',
            'aktivitas' => 'required',
            'jam_msk' => 'required',
            'jam_keluar' => 'required',
        ]);

        $add = new Agenda;
        $add->tgl = $request->tgl;
        $add->kelas_id = $request->kelas_id;
        $add->mapel_id = $request->mapel_id;
        $add->aktivitas = $request->aktivitas;
        $add->jam_msk = $request->jam_msk;
        $add->jam_keluar = $request->jam_keluar;
        $add->added_by = auth()->id();
        $add->save();

        $kelas = Kelas::findOrFail($request->kelas_id);
        return redirect('agenda/kelas/' . $kelas->slug)->with('status', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $agenda = Agenda::findOrFail($id);
        $user = auth()->user(); // Ambil user yang sedang login
        $hariIni = now()->locale('id')->dayName; // Dapatkan nama hari saat ini dalam Bahasa Indonesia

        // Tentukan tahun ajaran saat ini
        $currentMonth = now()->month;
        $currentYear = now()->year;
        if ($currentMonth >= 7) { // Juli hingga Desember
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        } else { // Januari hingga Juni
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        }
        $currentAcademicYear = "$startYear/$endYear";

        // Ambil kelas yang sesuai dengan agenda
        $kelas = Kelas::findOrFail($agenda->kelas_id);
        $kelas_id = $kelas->id;

        // Ambil jadwal pelajaran berdasarkan hari ini, guru yang sedang login, kelas yang relevan, dan tahun ajaran
        $jadwal = DB::table('jadwal_pelajarans')
            ->where('guru_id', $user->id)
            ->where('hari', $hariIni)
            ->where('kelas_id', $kelas_id)
            ->where('thn_ajaran', $currentAcademicYear)
            ->get();

        // Ambil ID mapel dari jadwal yang relevan
        $mapelIds = $jadwal->pluck('mapel_id')->toArray();

        // Ambil hanya mapel yang sesuai dengan jadwal
        $mapel = Mapel::whereIn('id', $mapelIds)->get();

        return view('guru.agenda.agenda_kelas.edit', compact('agenda', 'kelas_id', 'mapel'), [
            'title' => 'Edit Agenda Harian Kelas ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mapel_id' => 'required',
            'aktivitas' => 'required',
            'jam_msk' => 'required',
            'jam_keluar' => 'required',
        ]);

        $agenda = Agenda::findOrFail($id);

        // Ensure that 'kelas_id' is included in the request
        $agenda->kelas_id = $request->kelas_id;  // Check if 'kelas_id' is null here
        // $agenda->tgl = $request->tgl; // Komentar atau hapus baris ini untuk menjaga tanggal tetap
        $agenda->mapel_id = $request->mapel_id;
        $agenda->aktivitas = $request->aktivitas;
        $agenda->jam_msk = $request->jam_msk;
        $agenda->jam_keluar = $request->jam_keluar;

        $agenda->save();

        $kelas = Kelas::findOrFail($request->kelas_id);
        return redirect('agenda/kelas/' . $kelas->slug)->with('status', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agenda = Agenda::findOrFail($id);
        $kelas_id = $agenda->kelas_id;
        $agenda->delete();

        $kelas = Kelas::findOrFail($kelas_id);
        return redirect('agenda/kelas/' . $kelas->slug)->with('status', 'Data berhasil dihapus');
    }
}
