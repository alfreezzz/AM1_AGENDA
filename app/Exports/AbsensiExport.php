<?php

namespace App\Exports;

use App\Models\Absensiswa_Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Carbon;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kelas_id;
    protected $startDate;
    protected $endDate;

    public function __construct($kelas_id, $startDate = null, $endDate = null)
    {
        $this->kelas_id = $kelas_id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Absensiswa_Guru::where('kelas_id', $this->kelas_id)->with(['user', 'mapel', 'data_siswa']);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tgl', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Siswa',
            'Mata Pelajaran',
            'Guru',
            'Keterangan',
            'Waktu Ditambahkan'
        ];
    }

    public function map($absensi): array
    {
        return [
            Carbon::parse($absensi->tgl)->format('d M Y'),
            $absensi->data_siswa->nama_siswa ?? 'Tidak Ada',
            $absensi->mapel->nama_mapel ?? 'Tidak Ada',
            $absensi->user->name ?? 'Tidak Ada',
            $absensi->keterangan,
            Carbon::parse($absensi->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s')
        ];
    }
}
