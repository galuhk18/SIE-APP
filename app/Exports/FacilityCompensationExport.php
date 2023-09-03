<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class FacilityCompensationExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('facility_compensation')
        ->select([
            'id',
            'facility_name',
            'amount',
            'amount_compensation',
            'person_responsible',
            'telp',
            'status',
            'created_at'
        ])
        ->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'facility_name',
            'amount',
            'amount_compensation',
            'person_responsible',
            'telp',
            'status',
            'created_at'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
            'H' => 40,
            
           
        ];
    }

    public function map($row): array
    {
        $status = Config::get('enums.compensation_status');
        return [
            $row->id,
            $row->facility_name,
            $row->amount,
            $row->amount_compensation,
            $row->person_responsible,
            $row->telp,
            $status[$row->status],
            Carbon::parse($row->created_at)->format('Y-m-d h:m:s'),
            
        ];
    }
}
