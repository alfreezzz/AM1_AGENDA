<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absen_siswa;
use App\Models\Absensiswa_Guru;
use App\Models\Kelas;
use App\Models\Data_siswa;

class RekapanController extends Controller
{
    public function rekapanSekretaris($kelas_slug)
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

    public function rekapanGuru($kelas_slug)
    {
        $user = auth()->user(); // Ambil data pengguna yang login
        $kelas = Kelas::where('slug', $kelas_slug)->with('jurusan')->firstOrFail();

        // Jika pengguna adalah admin, ambil semua data
        if ($user->role === 'Admin') {
            $absensiswa_guru = Absensiswa_Guru::where('kelas_id', $kelas->id)
                ->with(['data_siswa', 'mapel', 'guru'])
                ->selectRaw('nis_id, mapel_id, added_by,
        SUM(CASE WHEN keterangan = "Hadir" THEN 1 ELSE 0 END) as total_hadir, 
        SUM(CASE WHEN keterangan = "Sakit" THEN 1 ELSE 0 END) as total_sakit, 
        SUM(CASE WHEN keterangan = "Izin" THEN 1 ELSE 0 END) as total_izin, 
        SUM(CASE WHEN keterangan = "Alpha" THEN 1 ELSE 0 END) as total_alpha')
                ->groupBy('nis_id', 'mapel_id', 'added_by')
                ->get();
        }
        // Jika pengguna adalah guru, hanya ambil data berdasarkan guru yang login
        else if ($user->role === 'Guru') {
            $absensiswa_guru = Absensiswa_Guru::where('kelas_id', $kelas->id)
                ->where('added_by', $user->id) // Hanya data yang ditambahkan oleh guru yang login
                ->with(['data_siswa', 'mapel'])
                ->selectRaw('nis_id, mapel_id, 
        SUM(CASE WHEN keterangan = "Hadir" THEN 1 ELSE 0 END) as total_hadir, 
        SUM(CASE WHEN keterangan = "Sakit" THEN 1 ELSE 0 END) as total_sakit, 
        SUM(CASE WHEN keterangan = "Izin" THEN 1 ELSE 0 END) as total_izin, 
        SUM(CASE WHEN keterangan = "Alpha" THEN 1 ELSE 0 END) as total_alpha')
                ->groupBy('nis_id', 'mapel_id')
                ->get();
        } else {
            return abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('guru.absensiswa_guru.absensiswa_guru_kelas.rekapan', compact('absensiswa_guru', 'kelas'), [
            'title' => 'Rekapan Absensi Siswa ' . $kelas->kelas . ' ' . $kelas->jurusan->jurusan_id . ' ' . $kelas->kelas_id
        ]);
    }
}
