<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@sid.app',
            'password' => Hash::make('admin'),
            'address' => 'Jalan ABC',
            'phone_number' => '081321908080',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('executive')->insert([
            'name' => 'Parjo',
            'username' => 'parjo',
            'email' => 'parjo@sid.app',
            'password' => Hash::make('parjo'),
            'address' => 'Jalan ABCD',
            'phone_number' => '081321908080',
            'picture' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
