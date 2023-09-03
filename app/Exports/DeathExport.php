<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DeathExport implements FromCollection,  WithHeadings, WithColumnWidths, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('death')
                ->select([
                    'nik',
                    'family_card',
                    'name',
                    'address',
                    'date_of_death',
                    'informer',
                    'informer_status'
                ])
                ->get();
    }

    public function headings(): array
    {
        return [
            'nik',
            'family_card',
            'name',
            'address',
            'date_of_death',
            'informer',
            'informer_status'
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
           
        ];
    }

    public function map($row): array
    {
        return [
            $row->nik,
            $row->family_card,
            $row->name,
            $row->address,
            Carbon::parse($row->date_of_death)->format('Y-m-d'),
            $row->informer,
            $row->informer_status
            
        ];
    }
}
