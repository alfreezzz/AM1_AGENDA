<?php

namespace App\Exports;

use App\Models\Absensiswa_Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $kelas_id;
    protected $filter;
    protected $start_date;
    protected $end_date;

    public function __construct($kelas_id, $filter = null, $start_date = null, $end_date = null)
    {
        $this->kelas_id = $kelas_id;
        $this->filter = $filter;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        $query = Absensiswa_Guru::where('kelas_id', $this->kelas_id)->with(['data_siswa', 'mapel', 'user']);

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
        $lastDate = null;
        $lastGuru = null;
        $lastMapel = null;
        $counter = 1;

        foreach ($data as $absen) {
            $currentDate = Carbon::parse($absen->tgl)->format('d M Y');
            $currentGuru = $absen->user->name ?? 'Tidak Ada';
            $currentMapel = $absen->mapel->nama_mapel ?? 'Tidak Ada';

            if ($lastDate !== $currentDate) {
                $grouped->push((object) ['header' => $currentDate]);
                $lastGuru = null;
                $lastMapel = null;
                $counter = 1;
            }

            if ($lastGuru !== $currentGuru) {
                $grouped->push((object) ['subheader_guru' => $currentGuru]);
                $lastMapel = null;
                $counter = 1;
            }

            if ($lastMapel !== $currentMapel) {
                $grouped->push((object) ['subheader_mapel' => $currentMapel]);
                $counter = 1;
            }

            $grouped->push((object) [
                'no' => $counter++,
                'nama_siswa' => $absen->data_siswa->nama_siswa ?? 'Tidak Ada',
                'keterangan' => $absen->keterangan,
                'created_at' => Carbon::parse($absen->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s'),
            ]);

            $lastDate = $currentDate;
            $lastGuru = $currentGuru;
            $lastMapel = $currentMapel;
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
        if (isset($absen->header)) {
            return [$absen->header, '', '', ''];
        }
        if (isset($absen->subheader_guru)) {
            return [$absen->subheader_guru, '', '', ''];
        }
        if (isset($absen->subheader_mapel)) {
            return [$absen->subheader_mapel, '', '', ''];
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
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '90EE90']],
        ]);

        $sheet->getStyle('C:C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D:D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
