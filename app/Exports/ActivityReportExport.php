<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class ActivityReportExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('activity_report')
        ->select([
            'id',
            'date_of_activity',
            'organization_name',
            'information',
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
            'information',
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
            'G' => 40,
        ];
    }

    public function map($row): array
    {
        $status = Config::get('enums.activity_report_status');
        return [
            $row->id,
            Carbon::parse($row->date_of_activity)->format('Y-m-d'),
            $row->organization_name,
            $row->information,
            $row->person_responsible,
            $status[$row->status],
            Carbon::parse($row->created_at)->format('Y-m-d h:m:s'),
            
        ];
    }
}
