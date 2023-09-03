<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DeathImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row) {
        
            DB::table('birth')->insert([
                'nik' => $row[0],
                'family_card' => $row[1],
                'name' => $row[2],
                'address' => $row[3],
                'date_of_death' => Carbon::parse($row[4])->format('Y-m-d'),
                'father_name' => $row[5],
                'mother_name' => $row[6],
                'created_at' => Carbon::now()
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
