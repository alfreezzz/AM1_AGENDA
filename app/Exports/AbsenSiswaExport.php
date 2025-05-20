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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;

class AbsenSiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $kelas_id;
    protected $filter;
    protected $start_date;
    protected $end_date;
    protected $dates = [];
    protected $studentAttendance = [];
    private static $counter = 1;

    public function __construct($kelas_id, $filter, $start_date, $end_date)
    {
        $this->kelas_id = $kelas_id;
        $this->filter = $filter;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        self::$counter = 1;
    }

    public function collection()
    {
        $query = Absen_siswa::where('kelas_id', $this->kelas_id)
            ->with('data_siswa');

        if ($this->filter == 'last_week') {
            $query->whereBetween('tgl', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
        } elseif ($this->filter == 'last_month') {
            $query->whereBetween('tgl', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
        } elseif ($this->filter == 'range' && $this->start_date && $this->end_date) {
            $query->whereBetween('tgl', [$this->start_date, $this->end_date]);
        }

        $attendanceData = $query->orderBy('tgl', 'asc')->get();

        // Get unique dates and store them as string format
        $this->dates = $attendanceData->pluck('tgl')
            ->unique()
            ->sort()
            ->values()
            ->map(function ($date) {
                return date('Y-m-d', strtotime($date));
            });

        // Get unique students with their attendance
        $students = $attendanceData->groupBy('data_siswa.id')->map(function ($studentAttendance, $key) {
            $student = $studentAttendance->first()->data_siswa;
            $attendance = collect();

            // Initialize attendance for all dates
            foreach ($this->dates as $date) {
                $record = $studentAttendance->firstWhere('tgl', $date);
                $attendance->put($date, $record ? strtoupper($record->keterangan) : '-');
            }

            return [
                'id' => $student->id,
                'nama_siswa' => $student->nama_siswa,
                'attendance' => $attendance
            ];
        })->values();

        // Store the student attendance data for later use in styles method
        $this->studentAttendance = $students;

        return $students;
    }

    public function headings(): array
    {
        $headers = ['No', 'Nama Siswa'];

        // Add empty cells for date headers (will be filled in styles())
        foreach ($this->dates as $date) {
            $headers[] = '';
        }

        return $headers;
    }

    public function map($student): array
    {
        $row = [
            self::$counter++,
            $student['nama_siswa']
        ];

        // Add attendance status for each date
        foreach ($this->dates as $date) {
            $row[] = $student['attendance'][$date];
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(2 + count($this->dates));
        $lastRow = $sheet->getHighestRow();

        // Insert a new row at the top for dates
        $sheet->insertNewRowBefore(1, 1);

        // Add dates to the first row
        $colIndex = 3; // Start from column C (after No and Nama Siswa)
        foreach ($this->dates as $date) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($col . '1', date('d/m/Y', strtotime($date)));
            $colIndex++;
        }

        // Style for date headers
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '9BBB59'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style for column headers (No, Nama Siswa)
        $sheet->getStyle('A2:' . $lastColumn . '2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '9BBB59'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Merge header cells
        $sheet->mergeCells('A1:A2'); // No
        $sheet->mergeCells('B1:B2'); // Nama Siswa
        $sheet->mergeCells('C2:' . $lastColumn . '2'); // Nama Siswa

        // Set text for merged cells
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Siswa');
        $sheet->setCellValue('C2', 'Keterangan');

        // Define fill colors for attendance status
        $fillColors = [
            'HADIR' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '92D050']], // Green
            'IZIN'  => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']], // Yellow
            'SAKIT' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '00B0F0']], // Blue
            'ALPHA' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]  // Red
        ];

        // Apply colors to attendance status cells
        foreach ($this->studentAttendance as $index => $student) {
            $rowIndex = $index + 3; // +3 because we have 2 header rows and rows are 1-indexed

            $colIndex = 3; // Start from column C
            foreach ($this->dates as $date) {
                $status = $student['attendance'][$date];
                if (isset($fillColors[$status])) {
                    $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                    $sheet->getStyle($colLetter . $rowIndex)->applyFromArray([
                        'fill' => $fillColors[$status]
                    ]);
                }
                $colIndex++;
            }
        }

        // Borders for all cells
        $sheet->getStyle('A1:' . $lastColumn . ($lastRow + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Center align student numbers and attendance status
        $sheet->getStyle('A3:A' . ($lastRow + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C1:' . $lastColumn . ($lastRow + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Set column width
        $sheet->getColumnDimension('A')->setWidth(5);  // No
        $sheet->getColumnDimension('B')->setWidth(30); // Nama Siswa

        // Set width for date columns
        for ($i = 2; $i <= count($this->dates) + 1; $i++) {
            $sheet->getColumnDimension(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1))->setWidth(12);
        }

        // Set row height
        $sheet->getDefaultRowDimension()->setRowHeight(25);

        // Freeze panes
        $sheet->freezePane('C3');

        return [];
    }
}