<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BirthImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row) {
        
            DB::table('birth')->insert([
                'nik' => $row[0],
                'no_akta' => $row[1],
                'name' => $row[2],
                'gender' => $row[3],
                'address' => $row[4],
                'date_of_birth' => Carbon::parse($row[5])->format('Y-m-d'),
                'father_name' => $row[6],
                'mother_name' => $row[7],
                'created_at' => Carbon::now()
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
