<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ServiceExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('service')
            ->select([
                'id',
                'nik',
                'name',
                'date_of_service',
                'information',
                'service_type',
                'created_at'
            ])
            ->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'nik',
            'name',
            'date_of_service',
            'information',
            'service_type',
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
            'G' => 40

        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->nik,
            $row->name,
            Carbon::parse($row->date_of_service)->format('Y-m-d'),
            $row->information,
            $row->service_type,
            Carbon::parse($row->created_at)->format('Y-m-d h:m:s'),

        ];
    }
}
