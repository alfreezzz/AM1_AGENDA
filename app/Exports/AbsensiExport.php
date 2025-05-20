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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $kelas_id;
    protected $filter;
    protected $start_date;
    protected $end_date;
    protected $isGuru;
    protected $userId;
    protected $headerRows = [];
    protected $dataMap = [];

    public function __construct($kelas_id, $filter = null, $start_date = null, $end_date = null, $isGuru = false, $userId = null)
    {
        $this->kelas_id = $kelas_id;
        $this->filter = $filter;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->isGuru = $isGuru;
        $this->userId = $userId;
    }

    public function collection()
    {
        $query = Absensiswa_Guru::where('kelas_id', $this->kelas_id)
            ->with(['data_siswa', 'mapel', 'user']);

        if ($this->filter === 'last_week') {
            $query->whereBetween('tgl', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek()
            ]);
        } elseif ($this->filter === 'last_month') {
            $query->whereBetween('tgl', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ]);
        } elseif ($this->filter === 'range' && $this->start_date && $this->end_date) {
            $query->whereBetween('tgl', [$this->start_date, $this->end_date]);
        }

        if ($this->isGuru) {
            $query->where('added_by', $this->userId);
        }

        $data = $query->orderBy('tgl')->get();

        return $this->formatData($data);
    }

    private function formatData($data)
    {
        $formatted = collect();
        $currentGuru = null;
        $currentMapel = null;
        $this->dataMap = [];

        // Group data by guru and mapel
        $groupedData = $data->groupBy(['user.name', 'mapel.nama_mapel']);

        foreach ($groupedData as $guru => $mapelGroup) {
            // Add Guru row
            $formatted->push(['Guru:', $guru]);

            foreach ($mapelGroup as $mapel => $attendanceData) {
                // Add Mapel row
                $formatted->push(['Mapel:', $mapel]);

                // Get unique dates for the header
                $dates = $attendanceData->pluck('tgl')->unique()->sort()->map(function ($date) {
                    return Carbon::parse($date)->format('d/m/Y');
                })->values();

                // Add table headers
                $headers = ['No', 'Nama Siswa'];
                foreach ($dates as $date) {
                    $headers[] = $date;
                }
                $formatted->push($headers);

                // Track the current row for data mapping
                $currentRow = count($formatted);

                // Group attendance by student
                $studentAttendance = $attendanceData->groupBy('data_siswa.nama_siswa');
                $counter = 1;

                foreach ($studentAttendance as $student => $records) {
                    $row = [$counter++, $student];
                    
                    // Store the starting column position for status values (column C = index 3)
                    $colIndex = 3;
                    
                    // Fill attendance status for each date
                    foreach ($dates as $date) {
                        $status = $records->first(function ($record) use ($date) {
                            return Carbon::parse($record->tgl)->format('d/m/Y') === $date;
                        });
                        
                        $statusValue = $status ? strtoupper($status->keterangan) : '-';
                        $row[] = $statusValue;
                        
                        // Store status value for cell coloring
                        if ($statusValue !== '-') {
                            $this->dataMap[] = [
                                'row' => $currentRow + 1,  // +1 because we're adding this row
                                'col' => $colIndex,
                                'value' => $statusValue
                            ];
                        }
                        
                        $colIndex++;
                    }

                    $formatted->push($row);
                    $currentRow++;
                }

                // Add empty row after each mapel section
                $formatted->push([]);
            }
        }

        return $formatted;
    }

    public function headings(): array
    {
        return []; // Headers are handled in formatData
    }

    public function map($row): array
    {
        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        // Get the last row and column
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        // Border style for table content
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        // Define fill colors for attendance status
        $fillColors = [
            'HADIR' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '92D050']], // Green
            'IZIN'  => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']], // Yellow
            'SAKIT' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '00B0F0']],  // Blue
            'ALPHA' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]  // Red 
        ];

        $row = 1;
        $tableStart = null;
        $currentTableEnd = null;

        while ($row <= $lastRow) {
            $firstCellValue = $sheet->getCellByColumnAndRow(1, $row)->getValue();

            if ($firstCellValue === 'Guru:' || $firstCellValue === 'Mapel:') {
                // Style header rows without borders
                $sheet->getStyle("A{$row}:B{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                if ($firstCellValue === 'Mapel:' && $currentTableEnd) {
                    // Apply borders to previous table section
                    $sheet->getStyle("A{$tableStart}:{$lastColumn}{$currentTableEnd}")
                        ->applyFromArray($borderStyle);
                    $tableStart = null;
                }
            } elseif ($firstCellValue === 'No') {
                // Start of new table section
                $tableStart = $row;

                // Style header row
                $sheet->getStyle("A{$row}:{$lastColumn}{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '9BBB59'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            } elseif (is_numeric($firstCellValue)) {
                // Data row - update current table end
                $currentTableEnd = $row;

                // Center align all cells except student name
                $sheet->getStyle("A{$row}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C{$row}:{$lastColumn}{$row}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            } elseif (empty($firstCellValue) && $tableStart && $currentTableEnd) {
                // Empty row after table - apply borders to completed section
                $sheet->getStyle("A{$tableStart}:{$lastColumn}{$currentTableEnd}")
                    ->applyFromArray($borderStyle);
                $tableStart = null;
                $currentTableEnd = null;
            }

            $row++;
        }

        // Apply borders to last table section if exists
        if ($tableStart && $currentTableEnd) {
            $sheet->getStyle("A{$tableStart}:{$lastColumn}{$currentTableEnd}")
                ->applyFromArray($borderStyle);
        }

        // Apply colors to attendance status cells
        foreach ($this->dataMap as $cellData) {
            $cellAddress = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cellData['col']) . $cellData['row'];
            
            if (isset($fillColors[$cellData['value']])) {
                $sheet->getStyle($cellAddress)->applyFromArray([
                    'fill' => $fillColors[$cellData['value']]
                ]);
            }
        }

        // Set column widths
        $sheet->getColumnDimension('B')->setWidth(30);
        foreach (range('C', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setWidth(15);
        }

        return [];
    }
}