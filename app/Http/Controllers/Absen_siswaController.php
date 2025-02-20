<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Absen_siswa;
use App\Models\Kelas;
use App\Models\Data_siswa;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use DB;
use App\Exports\AbsenSiswaExport;
use Maatwebsite\Excel\Facades\Excel;

class Absen_siswaController extends Controller
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

        return view('siswa.absen_siswa.index', compact('kelas'), [
            'title' => 'Daftar Kelas',
            'currentAcademicYear' => $currentAcademicYear,
        ]);
    }

    public function absen_siswaByClass($kelas_slug)
    {
        $kelas = Kelas::where('slug', $kelas_slug)->with('jurusan')->firstOrFail();
        $query = Absen_siswa::where('kelas_id', $kelas->id)->with(['data_siswa', 'kelas.jurusan']);

        // Ambil filter dari request
        $filter = request('filter');
        $startDate = request('start_date');
        $endDate = request('end_date');

        if ($filter == 'last_week') {
            $query->whereBetween('tgl', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
        } elseif ($filter == 'last_month') {
            $query->whereBetween('tgl', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]);
        } elseif ($filter == 'range' && $startDate && $endDate) {
            $query->whereBetween('tgl', [$startDate, $endDate]);
        }

        $absen_siswa = $query->orderBy('tgl', 'desc')->get()->groupBy('tgl');

        return view('siswa.absen_siswa.absen_siswa_kelas.index', compact('absen_siswa', 'kelas'), [
            'title' => 'Absensi Siswa ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id
        ]);
    }

    public function export(Request $request, $kelas_slug)
    {
        $kelas = Kelas::where('slug', $kelas_slug)->firstOrFail();
        $filter = $request->query('filter', '');
        $start_date = $request->query('start_date', '');
        $end_date = $request->query('end_date', '');

        // Hilangkan karakter "/" dan "\" dari nama file
        $filename = 'absensi_siswa_' . str_replace(['/', '\\'], '', $kelas->kelas . $kelas->jurusan->jurusan_id . $kelas->kelas_id . '_(sekretaris)_TA_' . $kelas->thn_ajaran) . '.xlsx';

        return Excel::download(new AbsenSiswaExport($kelas->id, $filter, $start_date, $end_date), $filename);
    }

    public function create()
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login

        if ($user->role == 'Sekretaris') {
            $data_siswa = Data_siswa::where('kelas_id', $user->kelas_id)->get();
            $kelas = Kelas::findOrFail($user->kelas_id); // Mendapatkan kelas untuk title
        } else {
            $data_siswa = Data_siswa::all();
            $kelas = null;
        }

        $title = $kelas ? 'Tambah Absensi Siswa ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id : 'Tambah Absensi Siswa';

        return view('siswa.absen_siswa.absen_siswa_kelas.create', compact('data_siswa', 'kelas'), ['title' => $title]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Dapatkan tanggal hari ini
        $today = Carbon::today();

        // Periksa apakah hari ini adalah Sabtu atau Minggu
        if ($today->isWeekend()) {
            return redirect()->back()->withErrors(['tgl' => 'Data tidak dapat ditambahkan pada hari Sabtu atau Minggu.']);
        }

        // Validasi input
        $request->validate([
            'tgl' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($today) {
                    if ($value !== $today->toDateString()) {
                        $fail('Tanggal hanya boleh diisi dengan hari ini.');
                    }
                },
            ],
            'siswa' => 'required|array',
            'siswa.*.keterangan' => 'nullable', // Allow keterangan to be nullable
        ]);

        // Cek apakah sudah ada data absensi untuk tanggal ini dan kelas yang sama
        $existingRecord = Absen_siswa::where('tgl', $request->tgl)
            ->whereHas('data_siswa', function ($query) {
                $query->where('kelas_id', Auth::user()->kelas_id);
            })
            ->exists();

        if ($existingRecord) {
            // Jika data sudah ada, berikan pesan error dan hentikan proses
            return redirect()->back()->withErrors(['tgl' => 'Data absensi untuk tanggal ini sudah ada.']);
        }

        // Loop melalui setiap siswa dari input form
        foreach ($request->siswa as $siswa_id => $data) {
            // Ambil data siswa berdasarkan ID siswa
            $siswa = Data_siswa::findOrFail($siswa_id);

            // Tetapkan nilai default 'Hadir' jika keterangan tidak diisi
            $keterangan = $data['keterangan'] ?? 'Hadir';

            // Simpan absen siswa dengan nama siswa, kelas_id, dan nis_id
            Absen_siswa::create([
                'tgl' => $request->tgl,
                'nama_siswa' => $siswa->nama_siswa,
                'keterangan' => $keterangan,
                'kelas_id' => $siswa->kelas_id,
                'nis_id' => $siswa->id,
            ]);
        }

        $kelas = Kelas::findOrFail($siswa->kelas_id);
        return redirect('absen_siswa/kelas/' . $kelas->slug)->with('status', 'Data berhasil ditambah');
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
        // Mengambil data absensi siswa beserta data siswa terkait
        $absen_siswa = Absen_siswa::with('data_siswa')->findOrFail($id);

        // Mendapatkan `kelas_id` dari data siswa terkait
        $kelas = Kelas::findOrFail($absen_siswa->data_siswa->kelas_id);

        // Menyertakan `kelas_id` di dalam title
        $title = 'Edit Absensi Siswa ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id;

        // Mengirim data absensi dan kelas ke view
        return view('siswa.absen_siswa.absen_siswa_kelas.edit', compact('absen_siswa', 'kelas'), ['title' => $title]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'keterangan' => 'nullable', // Allow keterangan to be nullable
        ]);

        // Find the attendance record (absen_siswa) by its ID
        $absen_siswa = Absen_siswa::findOrFail($id);

        // Update the attendance record
        //$absen_siswa->tgl = $request->tgl; // Update the date
        $absen_siswa->keterangan = $request->keterangan; // Allow nullable keterangan
        $absen_siswa->save(); // Save the changes

        $kelas = $absen_siswa->kelas;
        return redirect('absen_siswa/kelas/' . $kelas->slug)->with('status', 'Data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absen_siswa = Absen_siswa::findOrFail($id);
        $absen_siswa->delete();

        $kelas = $absen_siswa->kelas;
        return redirect('absen_siswa/kelas/' . $kelas->slug)->with('status', 'Data berhasil dihapus');
    }
}
