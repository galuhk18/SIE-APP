<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('building_management')->insert([
            [
                'building_code' => 'GA01',
                'building_name' => 'gedung pendopo',
                'condition' => 'baik',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'building_code' => 'GA02',
                'building_name' => 'gedung aula',
                'condition' => 'baik',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'building_code' => 'GA03',
                'building_name' => 'ruang rapat 1',
                'condition' => 'baik',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'building_code' => 'GA04',
                'building_name' => 'ruang rapat 2',
                'condition' => 'baik',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'building_code' => 'GA05',
                'building_name' => 'gedung serbaguna',
                'condition' => 'baik',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
