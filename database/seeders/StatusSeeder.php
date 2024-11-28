<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('status')->count() == 0) {
        DB::table('status')->insert([
            ['name' => 'Menunggu'],
            ['name' => 'Diproses'],
            ['name' => 'Proses Selesai'],
            ['name' => 'Selesai'],
        ]);
    }
}
}