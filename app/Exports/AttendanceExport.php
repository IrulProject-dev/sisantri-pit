<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize , WithStyles
{
    protected $attendances;
    protected $filters;

    public function __construct($attendances, $filters)
    {
        $this->attendances = $attendances;
        $this->filters = $filters;
    }

    public function collection()
    {
        return $this->attendances;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Sesi',
            'Nama Santri',
            'Divisi',
            'Angkatan',
            'Status'
        ];
    }

    public function map($attendance): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            \Carbon\Carbon::parse($attendance->date)->format('d M Y'),
            $attendance->attendanceSession->name ?? 'N/A', // Perbaikan di sini
            $attendance->user->name ?? 'N/A',
            $attendance->user->division->name ?? 'N/A',
            $attendance->user->batch->name ?? 'N/A',
            $this->mapStatus($attendance->status)
        ];
    }

    protected function mapStatus($status)
    {
        $mapping = [
            'hadir' => 'Hadir',
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'alfa' => 'Alfa',
            'terlambat' => 'Terlambat',
            'piket' => 'Piket'
        ];

        return $mapping[strtolower($status)] ?? $status;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the header row
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'D9E1F2']
                ]
            ],

            // Set border for all cells
            'A1:G' . ($this->attendances->count() + 1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]
        ];
    }
}
