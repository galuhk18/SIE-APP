<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class FacilityManagementExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('facility_management')
        ->select([
            'facility_code',
            'facility_name',
            'condition',
            'stock'
        ])
        ->get();
    }

    public function headings(): array
    {
        return [
            'facility_code',
            'facility_name',
            'condition',
            'stock'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
        ];
    }

    public function map($row): array
    {
    
        return [
            $row->facility_code,
            $row->facility_name,
            $row->condition,
            $row->stock
        ];
    }
}
