<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class FormDeathExport implements WithHeadings, WithColumnWidths
{
    public function headings(): array
    {
        return [
            'nik',
            'family_card',
            'name',
            'address',
            'date_of_death',
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
           
        ];
    }
}
