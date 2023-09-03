<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DecisionExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('decision')
            ->select([
                'id',
                'decision',
                'type_of_decision',
                'decision_date',
                'problem',
                'realization_date',
                'created_at'
            ])
            ->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'decision',
            'type_of_decision',
            'decision_date',
            'problem',
            'realization_date',
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
            'F' => 40,
            'G' => 40

        ];
    }
    public function map($row): array
    {
        return [
            $row->id,
            $row->decision,
            $row->type_of_decision,
            Carbon::parse($row->decision_date)->format('Y-m-d'),
            $row->problem,
            Carbon::parse($row->realization_date)->format('Y-m-d'),
            Carbon::parse($row->created_at)->format('Y-m-d h:m:s'),

        ];
    }
}
