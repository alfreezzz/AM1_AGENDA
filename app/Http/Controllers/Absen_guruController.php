<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Absen_guru;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\User;
use App\Notifications\YourCustomNotification;
use App\Events\AbsenGuruSaved;
use DB;

class Absen_guruController extends Controller
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
            $user = auth()->user();

            // Ambil kelas yang diajarkan oleh guru
            $kelas = $user->dataKelas()
                ->where('thn_ajaran', $currentAcademicYear)
                ->with('jurusan')
                ->get();

            // Tambahkan penanda apakah kelas ini sesuai jadwal hari ini
            foreach ($kelas as $kls) {
                $jadwalHariIni = DB::table('jadwal_pelajarans')
                    ->where('guru_id', $user->id)
                    ->where('hari', $hariIni)
                    ->where('kelas_id', $kls->id)
                    ->where('thn_ajaran', $currentAcademicYear)
                    ->exists();

                $kls->harus_diisi = $jadwalHariIni; // true kalau ada jadwal hari ini

                // ✅ Tambahan: cek apakah absen sudah diisi hari ini
                $absenHariIni = Absen_guru::where('kelas_id', $kls->id)
                    ->whereDate('tgl', now()->toDateString())
                    ->where('added_by', $user->id)
                    ->exists();

                $kls->sudah_diisi = $absenHariIni; // true kalau sudah diisi
            }
        } elseif (auth()->user()->role === 'Admin' && $showAll) {
            $kelas = Kelas::with('jurusan')->get(); // Admin dapat melihat semua kelas
        } else {
            $kelas = Kelas::with('jurusan')
                ->where('thn_ajaran', $currentAcademicYear)
                ->get(); // Default untuk admin tanpa `show_all`
        }

        return view('guru.absen_guru.index', compact('kelas'), [
            'title' => 'Daftar Kelas',
            'currentAcademicYear' => $currentAcademicYear,
        ]);
    }

    public function absen_guruByClass(Request $request, $slug)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();

        $userRole = auth()->user()->role;

        // Set the title based on the user's role
        $title = ($userRole === 'Guru' || $userRole === 'Admin') ? 'Absensi' : 'Tugas';

        $filter = $request->query('filter');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $absenGuruQuery = Absen_guru::where('kelas_id', $kelas->id)
            ->with(['user', 'mapel']) // Tambahkan 'user' untuk memuat data nama pengguna
            ->orderBy('tgl', 'desc');

        if ($filter === 'last_week') {
            $absenGuruQuery->whereBetween('tgl', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek()
            ]);
        } elseif ($filter === 'last_month') {
            $absenGuruQuery->whereBetween('tgl', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ]);
        } elseif ($filter === 'range' && $startDate && $endDate) {
            $absenGuruQuery->whereBetween('tgl', [$startDate, $endDate]);
        }

        if (auth()->user()->role === 'Guru') {
            $user = auth()->user();
            $assignedMapels = Absen_guru::where('kelas_id', $kelas->id)
                ->where('added_by', $user->id)
                ->pluck('mapel_id');

            // Filter agenda berdasarkan mapel yang diajarkan
            $absenGuruQuery->whereIn('mapel_id', $assignedMapels);
        }

        $absen_guru = $absenGuruQuery->get();

        return view('guru.absen_guru.absen_guru_kelas.index', compact('absen_guru', 'kelas', 'filter', 'startDate', 'endDate'), ['title' => $title . ' di Kelas ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($kelas_id)
    {
        $user = auth()->user();
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

        return view('guru.absen_guru.absen_guru_kelas.create', [
            'kelas_id' => $kelas_id,
            'mapel' => $mapel
        ], ['title' => 'Tambah Absensi Harian Kelas ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mapel_id' => 'required',
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
            'keterangan' => 'required',
            'tugas.*' => 'nullable|mimes:pdf|max:15360',
            'keterangantugas' => 'required',
        ]);

        $absen_guru = new Absen_guru;
        $absen_guru->mapel_id = $request->mapel_id;
        $absen_guru->tgl = $request->tgl;
        $absen_guru->kelas_id = $request->kelas_id;
        $absen_guru->keterangan = $request->keterangan;
        $absen_guru->keterangantugas = $request->keterangantugas;

        // Simpan semua file tugas jika ada
        $tugasFiles = [];
        if ($request->hasFile('tugas')) {
            foreach ($request->file('tugas') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/tugas', $fileName, 'public');
                $tugasFiles[] = $filePath;
            }
        }

        // Simpan array file path sebagai JSON
        $absen_guru->tugas = json_encode($tugasFiles);

        $absen_guru->added_by = auth()->id();
        $absen_guru->save();

        // Ambil slug kelas
        $kelas = Kelas::findOrFail($request->kelas_id);

        // Data notifikasi
        $data = [
            'title' => 'Absensi Terbaru',
            'message' => 'Absensi baru telah ditambahkan untuk kelas Anda.',
            'link' => url('/absen_guru/kelas/' . $kelas->slug), // Gunakan slug
        ];

        // Kirim notifikasi ke Sekretaris
        $users = User::where('role', 'Sekretaris')
            ->where('kelas_id', $request->kelas_id)
            ->get();

        foreach ($users as $user) {
            $user->notify(new YourCustomNotification($data));
        }

        return redirect('absen_guru/kelas/' . $kelas->slug)->with('status', 'Absensi berhasil ditambahkan');
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
        $absen_guru = Absen_guru::findOrFail($id);
        $user = auth()->user();
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

        $kelas = Kelas::findOrFail($absen_guru->kelas_id);
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

        return view('guru.absen_guru.absen_guru_kelas.edit', compact('absen_guru', 'kelas_id', 'mapel'), [
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
            'keterangan' => 'required',
            'tugas.*' => 'nullable|mimes:pdf|max:15360', // Validasi untuk multiple files
            'keterangantugas' => 'required',
        ]);

        $absen_guru = Absen_guru::findOrFail($id);

        $absen_guru->mapel_id = $request->mapel_id;
        // $absen_guru->tgl = $request->tgl;
        $absen_guru->kelas_id = $request->kelas_id;
        $absen_guru->keterangan = $request->keterangan;
        $absen_guru->keterangantugas = $request->keterangantugas;

        // Ambil tugas yang ada jika ada, decode menjadi array
        $existingTugas = $absen_guru->tugas ? json_decode($absen_guru->tugas, true) : [];

        // Proses setiap file yang diunggah
        if ($request->hasFile('tugas')) {
            foreach ($request->file('tugas') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/tugas', $fileName, 'public');
                $existingTugas[] = $filePath; // Tambahkan file baru ke dalam array existingTugas
            }
        }

        // Update kolom tugas dengan semua file yang ada dalam bentuk JSON
        $absen_guru->tugas = json_encode($existingTugas);

        $absen_guru->save();
        $kelas = Kelas::findOrFail($request->kelas_id);
        return redirect('absen_guru/kelas/' . $kelas->slug)->with('status', 'Absensi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absen_guru = Absen_guru::findOrFail($id);
        $kelas_id = $absen_guru->kelas_id;
        $absen_guru->delete();

        $kelas = Kelas::findOrFail($kelas_id);
        return redirect('absen_guru/kelas/' . $kelas->slug)->with('status', 'Absensi berhasil dihapus');
    }
}
