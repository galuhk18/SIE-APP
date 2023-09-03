<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class FacilityRentalExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('facility_rental')
        ->select([
            'id',
            'facility_code',
            'amount',
            'start_date',
            'end_date',
            'rental_reasons',
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
            'facility_code',
            'amount',
            'start_date',
            'end_date',
            'rental_reasons',
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
            'F' => 60,
            'G' => 30,
            'H' => 30,
            'I' => 30,
            'J' => 40
           
        ];
    }

    public function map($row): array
    {
        $status = Config::get('enums.rental_status');
        return [
            $row->id,
            $row->facility_code,
            $row->amount,
            Carbon::parse($row->start_date)->format('Y-m-d'),
            Carbon::parse($row->end_date)->format('Y-m-d'),
            $row->rental_reasons,
            $row->person_responsible,
            $row->telp,
            $status[$row->status],
            Carbon::parse($row->created_at)->format('Y-m-d h:m:s'),
            
        ];
    }
}
