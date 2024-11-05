<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatkerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('table_satker')->insert([
            ['nama_satker' => 'Pusdatin'],
        ]);
    }
}
