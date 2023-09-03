<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BirthExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('birth')
                ->select([
                    'nik',
                    'no_akta',
                    'name',
                    'gender',
                    'address',
                    'date_of_birth',
                    'father_name',
                    'mother_name'
                ])
                ->get();
    }

    public function headings(): array
    {
        return [
            'nik',
            'no_akta',
            'name',
            'gender',
            'address',
            'date_of_birth',
            'father_name',
            'mother_name'
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
            'H' => 30
           
        ];
    }

    public function map($row): array
    {
        return [
            $row->nik,
            $row->no_akta,
            $row->name,
            $row->gender,
            $row->address,
            Carbon::parse($row->date_of_birth)->format('Y-m-d'),
            $row->father_name,
            $row->mother_name
            
        ];
    }

}
