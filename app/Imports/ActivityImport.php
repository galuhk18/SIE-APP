<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ActivityImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row) {
        
            DB::table('activity')->insert([
                'name' => $row[0],
                'date_of_activity' => Carbon::parse($row[1])->format('Y-m-d'),
                'address' => $row[2],
                'information' => $row[3],
                'created_at' => Carbon::now()
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
