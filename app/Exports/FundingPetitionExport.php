<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class FundingPetitionExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('funding_petition')
        ->select([
            'id',
            'date_of_activity',
            'organization_name',
            'budget_amount',
            'event_name',
            'person_responsible',
            'status',
            'created_at'
        ])
        ->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'date_of_activity',
            'organization_name',
            'budget_amount',
            'event_name',
            'person_responsible',
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
            'H' => 40
           
        ];
    }

    public function map($row): array
    {
        $status = Config::get('enums.funding_petition_status');
        return [
            $row->id,
            Carbon::parse($row->date_of_activity)->format('Y-m-d'),
            $row->organization_name,
            $row->budget_amount,
            $row->event_name,
            $row->person_responsible,
            $status[$row->status],
            Carbon::parse($row->created_at)->format('Y-m-d h:m:s'),
            
        ];
    }

}
