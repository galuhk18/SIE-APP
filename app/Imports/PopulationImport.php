<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PopulationImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row) {
        
            DB::table('population')->insert([
                'nik' => $row[0],
                'family_card' => $row[1],
                'name' => $row[2],
                'gender' => $row[3],
                'address' => $row[4],
                'date_of_birth' => Carbon::parse($row[5])->format('Y-m-d'),
                'birth_place' => $row[6],
                'phone_number' => $row[7],
                'religion' => $row[8],
                'citizenship' => $row[9],
                'married' => $row[10],
                'job' => $row[11],
                'father_name' => $row[12],
                'mother_name' => $row[13],
                'created_at' => Carbon::now()
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
