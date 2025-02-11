<?php

namespace App\Exports;

use App\Models\Absen_siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Collection;

class AbsenSiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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

        $data = $query->orderBy('tgl', 'desc')->get();

        return $this->groupData($data);
    }

    private function groupData($data)
    {
        $grouped = collect();
        $counter = 1;
        $lastDate = null;

        foreach ($data as $absen) {
            if ($lastDate !== $absen->tgl) {
                $grouped->push((object) ['header' => (string) $absen->tgl]); // Simpan header sebagai object
                $counter = 1;
            }

            $grouped->push((object) [
                'no' => $counter++,
                'nama_siswa' => $absen->data_siswa->nama_siswa,
                'keterangan' => $absen->keterangan,
                'created_at' => $absen->created_at->format('d M Y H:i:s'),
            ]);

            $lastDate = $absen->tgl;
        }

        return $grouped;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Keterangan',
            'Waktu Ditambahkan',
        ];
    }

    public function map($absen): array
    {
        // Jika ini adalah header tanggal
        if (isset($absen->header)) {
            return [$absen->header, '', '', ''];
        }

        return [
            $absen->no ?? '',
            $absen->nama_siswa ?? '',
            $absen->keterangan ?? '',
            $absen->created_at ?? '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling header
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '90EE90']],
        ]);

        // Set kolom "Keterangan" (C) dan "Waktu Ditambahkan" (D) agar center
        $sheet->getStyle('C:C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D:D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
