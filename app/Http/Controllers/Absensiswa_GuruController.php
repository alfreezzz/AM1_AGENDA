<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Absensiswa_Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Data_siswa;
use DB;

class Absensiswa_GuruController extends Controller
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
            $user = auth()->user(); // Ambil data user
            $kelasIds = DB::table('jadwal_pelajarans')
                ->where('guru_id', $user->id)
                ->where('hari', $hariIni)
                ->where('thn_ajaran', $currentAcademicYear)
                ->pluck('kelas_id'); // Ambil hanya ID kelas dari jadwal pelajaran

            // Ambil data kelas yang sesuai jadwal
            $kelas = Kelas::with('jurusan')
                ->whereIn('id', $kelasIds)
                ->get();
        } elseif (auth()->user()->role === 'Admin' && $showAll) {
            $kelas = Kelas::with('jurusan')->get(); // Admin dapat melihat semua kelas
        } else {
            $kelas = Kelas::with('jurusan')
                ->where('thn_ajaran', $currentAcademicYear)
                ->get(); // Default untuk admin tanpa `show_all`
        }

        return view('guru.absensiswa_guru.index', compact('kelas'), [
            'title' => 'Daftar Kelas',
            'currentAcademicYear' => $currentAcademicYear,
        ]);
    }

    public function absensiswa_guruByClass(Request $request, $slug)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $filterDate = $request->query('date') ?? Carbon::today()->toDateString();

        $absensiQuery = Absensiswa_Guru::where('kelas_id', $kelas->id)
            ->with(['user', 'mapel']) // Tambahkan 'user' untuk memuat data nama pengguna
            ->orderBy('tgl', 'desc');

        // Filter berdasarkan tanggal jika diperlukan
        if ($filterDate) {
            $absensiQuery->whereDate('tgl', $filterDate);
        }

        // Jika user adalah Guru, terapkan filter berdasarkan `mapel_id` dari `guru_mapel`
        if (auth()->user()->role === 'Guru') {
            $user = auth()->user(); // Ambil data user yang login
            $assignedMapels = DB::table('guru_mapel')
                ->where('user_id', auth()->user()->id)
                ->pluck('mapel_id');

            // Filter agenda berdasarkan mapel yang diajarkan
            $absensiQuery->whereIn('mapel_id', $assignedMapels);
        }

        $absensi = $absensiQuery->get();

        return view('guru.absensiswa_guru.absensiswa_guru_kelas.index', compact('absensi', 'kelas', 'filterDate'), [
            'title' => 'Absensi Siswa Harian Kelas ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
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

        $kelas = Kelas::findOrFail($kelas_id);

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

        // Ambil data siswa berdasarkan kelas yang dipilih
        $data_siswa = Data_siswa::where('kelas_id', $kelas_id)->get();

        return view('guru.absensiswa_guru.absensiswa_guru_kelas.create', [
            'kelas_id' => $kelas_id,
            'mapel' => $mapel,
            'data_siswa' => $data_siswa, // Kirim data siswa ke view
        ], [
            'title' => 'Tambah Absensi Siswa Harian Kelas ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'siswa' => 'required|array',
            'siswa.*.keterangan' => 'nullable',
        ]);

        foreach ($request->siswa as $siswa_id => $data) {
            // Ambil data siswa berdasarkan ID siswa
            $siswa = Data_siswa::findOrFail($siswa_id);

            // Tetapkan nilai default 'Hadir' jika keterangan tidak diisi
            $keterangan = $data['keterangan'] ?? 'Hadir';

            // Simpan absen siswa dengan nama siswa, kelas_id, dan nis_id
            Absensiswa_Guru::create([
                'tgl' => $request->tgl,
                'nama_siswa' => $siswa->nama_siswa,
                'keterangan' => $keterangan,
                'kelas_id' => $siswa->kelas_id,
                'nis_id' => $siswa->id,
                'mapel_id' => $request->mapel_id,
                'added_by' => auth()->id(),
            ]);
        }

        $kelas = Kelas::findOrFail($request->kelas_id);
        return redirect('absensiswa_guru/kelas/' . $kelas->slug)->with('status', 'Data berhasil ditambah');
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
        $absensi = Absensiswa_Guru::findOrFail($id);
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
        $kelas = Kelas::findOrFail($absensi->kelas_id);
        $kelas_id = $kelas->id;
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

        return view('guru.absensiswa_guru.absensiswa_guru_kelas.edit', compact('absensi', 'kelas_id', 'mapel'), [
            'title' => 'Edit Absensi Siswa Harian Kelas ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mapel_id' => 'required',
            'keterangan' => 'nullable',
        ]);

        $absensi = Absensiswa_Guru::findOrFail($id);

        // Ensure that 'kelas_id' is included in the request
        $absensi->kelas_id = $request->kelas_id;  // Check if 'kelas_id' is null here
        // $absensi->tgl = $request->tgl; // Komentar atau hapus baris ini untuk menjaga tanggal tetap
        $absensi->mapel_id = $request->mapel_id;
        $absensi->keterangan = $request->keterangan;


        $absensi->save();

        $kelas = Kelas::findOrFail($request->kelas_id);
        return redirect('absensiswa_guru/kelas/' . $kelas->slug)->with('status', 'Data berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absensi = Absensiswa_Guru::findOrFail($id);
        $kelas_id = $absensi->kelas_id;
        $absensi->delete();

        $kelas = Kelas::findOrFail($kelas_id);
        return redirect('absensiswa_guru/kelas/' . $kelas->slug)->with('status', 'Data berhasil dihapus');
    }
}
