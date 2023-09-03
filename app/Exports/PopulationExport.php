<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PopulationExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    public function collection()
    {
        return DB::table('population')
                ->select([
                    'nik',
                    'family_card',
                    'name',
                    'gender',
                    'address',
                    'date_of_birth',
                    'birth_place',
                    'phone_number',
                    'religion',
                    'citizenship',
                    'married',
                    'job',
                    'father_name',
                    'mother_name'
                ])
                ->get();
    }

    public function headings(): array
    {
        return [
            'nik',
            'family_card',
            'name',
            'gender',
            'address',
            'date_of_birth',
            'birth_place',
            'phone_number',
            'religion',
            'citizenship',
            'married',
            'job',
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
            'H' => 30,
            'I' => 30,
            'J' => 30,
            'K' => 30,
            'L' => 30,
            'M' => 30,
            'N' => 30
        ];
    }

    public function map($row): array
    {
        return [
            $row->nik,
            $row->family_card,
            $row->name,
            $row->gender,
            $row->address,
            Carbon::parse($row->date_of_birth)->format('Y-m-d'),
            $row->birth_place,
            $row->phone_number,
            $row->religion,
            $row->citizenship,
            $row->married,
            $row->job,
            $row->father_name,
            $row->mother_name
            
        ];
    }
}
