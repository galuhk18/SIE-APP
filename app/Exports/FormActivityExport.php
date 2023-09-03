<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class FormActivityExport implements WithHeadings, WithColumnWidths
{
    public function headings(): array
    {
        return [
            'activity_name',
            'date_of_activity',
            'address',
            'information',
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
}
