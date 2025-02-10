<?php

namespace App\Exports;

use App\Models\Absen_siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsenSiswaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kelas_id;
    protected $filter;
    protected $start_date;
    protected $end_date;

    public function __construct($kelas_id, $filter, $start_date, $end_date)
    {
        $this->kelas_id = $kelas_id;
        $this->filter = $filter;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        $query = Absen_siswa::where('kelas_id', $this->kelas_id)->with('data_siswa');

        if ($this->filter == 'last_week') {
            $query->whereBetween('tgl', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
        } elseif ($this->filter == 'last_month') {
            $query->whereBetween('tgl', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
        } elseif ($this->filter == 'range' && $this->start_date && $this->end_date) {
            $query->whereBetween('tgl', [$this->start_date, $this->end_date]);
        }

        return $query->orderBy('tgl', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Siswa',
            'Keterangan',
            'Waktu Ditambahkan',
        ];
    }

    public function map($absen): array
    {
        return [
            $absen->tgl,
            $absen->data_siswa->nama_siswa,
            $absen->keterangan,
            $absen->created_at->format('d M Y H:i:s'),
        ];
    }
}
