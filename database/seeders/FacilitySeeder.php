<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('facility_management')->insert([
            [
                'facility_code' => 'FA1',
                'facility_name' => 'kursi kantor',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA2',
                'facility_name' => 'meja rapat',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA3',
                'facility_name' => 'kursi plastik',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA4',
                'facility_name' => 'sofa tamu 1',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA5',
                'facility_name' => 'sofa tamu 2',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA6',
                'facility_name' => 'meja tamu 1',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA7',
                'facility_name' => 'meja tamu 2',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA8',
                'facility_name' => 'kipas blower',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA9',
                'facility_name' => 'kipas angin',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA10',
                'facility_name' => 'AC duduk',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA11',
                'facility_name' => 'laptop staf',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA12',
                'facility_name' => 'komputer staf',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA13',
                'facility_name' => 'taplak meja kecil',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA14',
                'facility_name' => 'taplak meja besar',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA15',
                'facility_name' => 'meja bundar',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA16',
                'facility_name' => 'microphone',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA17',
                'facility_name' => 'speaker',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA19',
                'facility_name' => 'TV LED',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA20',
                'facility_name' => 'TV Biasa',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'facility_code' => 'FA22',
                'facility_name' => 'proyektor',
                'condition' => 'baik',
                'stock' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
