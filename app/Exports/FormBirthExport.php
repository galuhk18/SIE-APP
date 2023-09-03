<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class FormBirthExport implements WithHeadings, WithColumnWidths
{
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
            'H' => 30,
           
        ];
    }
}
