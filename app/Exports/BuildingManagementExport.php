<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class BuildingManagementExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('building_management')
        ->select([
            'building_code',
            'building_name',
            'condition',
            'is_rental'
        ])
        ->get();
    }

    public function headings(): array
    {
        return [
            'building_code',
            'building_name',
            'condition',
            'is_rental'
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
            $row->building_code,
            $row->building_name,
            $row->condition,
            ($row->is_rental) ? "disewa" : "tidak_disewa"
        ];
    }
}
