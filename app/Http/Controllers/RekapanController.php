<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absen_siswa;
use App\Models\Kelas;
use App\Models\Data_siswa;

class RekapanController extends Controller
{
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

        // Cek apakah admin ingin melihat semua data atau hanya tahun ajaran sekarang
        $showAll = $request->query('show_all', false);

        if (auth()->user()->role === 'Guru') {
            // Guru hanya melihat kelas yang diajarkan
            $kelas = auth()->user()->dataKelas()
                ->where('thn_ajaran', $currentAcademicYear)
                ->with('jurusan')
                ->get();
        } elseif (auth()->user()->role === 'Admin' && $showAll) {
            // Admin dapat melihat semua kelas
            $kelas = Kelas::with('jurusan')->get();
        } else {
            // Default untuk admin tanpa `show_all`
            $kelas = Kelas::with('jurusan')
                ->where('thn_ajaran', $currentAcademicYear)
                ->get();
        }

        return view('siswa.absen_siswa.rekapan', compact('kelas'), [
            'title' => 'Daftar Kelas',
            'currentAcademicYear' => $currentAcademicYear,
        ]);
    }

    public function rekapanByClass($kelas_slug)
    {
        // Cari kelas berdasarkan slug
        $kelas = Kelas::where('slug', $kelas_slug)->with('jurusan')->firstOrFail();

        // Ambil data absensi berdasarkan siswa
        $absen_siswa = Absen_siswa::where('kelas_id', $kelas->id)
            ->with(['data_siswa'])
            ->selectRaw('nis_id, 
                     SUM(CASE WHEN keterangan = "Hadir" THEN 1 ELSE 0 END) as total_hadir, 
                     SUM(CASE WHEN keterangan = "Sakit" THEN 1 ELSE 0 END) as total_sakit, 
                     SUM(CASE WHEN keterangan = "Izin" THEN 1 ELSE 0 END) as total_izin, 
                     SUM(CASE WHEN keterangan = "Alpha" THEN 1 ELSE 0 END) as total_alpha')
            ->groupBy('nis_id')
            ->get();

        return view('siswa.absen_siswa.absen_siswa_kelas.rekapan', compact('absen_siswa', 'kelas'), [
            'title' => 'Rekapan Absensi Siswa ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id
        ]);
    }
}
