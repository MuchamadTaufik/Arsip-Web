<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PegawaiExport implements FromQuery, WithHeadings, WithStyles, WithMapping, ShouldAutoSize
{
    use Exportable;

    protected $query;
    protected $filters;

    public function __construct($query, $filters)
    {
        $this->query = $query;
        $this->filters = $filters;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            ['Data Pegawai - ' . date('d F Y')],
            [''],
            ['Filter:'],
            ['Unit: ' . ($this->filters['unit'] ?? 'Semua Unit')],
            ['Status: ' . ($this->filters['status'] ?? 'Semua Status')],
            ['Hubungan Kerja: ' . ($this->filters['hubungan_kerja'] ?? 'Semua Hubungan Kerja')],
            [''],
            [
                'No',
                'NIP',
                'Nama Pegawai',
                'Unit',
                'Jabatan',
                'Status',
                'Hubungan Kerja',
            ]
        ];
    }

    public function map($pegawai): array
    {
        static $counter = 0;
        $counter++;
        
        return [
            $counter,
            $pegawai->biodata->nip,
            $pegawai->biodata->nama_pegawai,
            $pegawai->unit->name,
            $pegawai->jabatan,
            $pegawai->status,
            $pegawai->hubungan_kerja,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            3 => ['font' => ['bold' => true]],
            8 => ['font' => ['bold' => true], 
                  'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => '4299E1']]],
            'A8:G8' => ['font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}