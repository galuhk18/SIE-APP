<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ActivityExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('activity')
            ->select([
                'id',
                'name',
                'date_of_activity',
                'address',
                'information',
                'created_at'
            ])
            ->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'activity_name',
            'date_of_activity',
            'address',
            'information',
            'created_at'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 40,
            'D' => 30,
            'E' => 30,
            'F' => 40,

        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            Carbon::parse($row->date_of_activity)->format('Y-m-d'),
            $row->address,
            $row->information,
            Carbon::parse($row->created_at)->format('Y-m-d h:m:s'),

        ];
    }
}
