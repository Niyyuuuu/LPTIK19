<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAndTechnicianSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     *
     * @return void
     */
    public function run()
    {
        // Cek apakah pengguna dengan username 'admin' sudah ada
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@localhost',
                'password' => Hash::make('$Admin77'),
                'role' => 'Admin',
            ]);
        }

        // Cek apakah pengguna dengan username 'technician' sudah ada
        if (!User::where('username', 'teknisi-1')->exists()) {
            User::create([
                'name' => 'Teknisi Nabil',
                'username' => 'teknisi-1',
                'email' => 'teknisi-1@localhost',
                'password' => Hash::make('tech$888'), 
                'role' => 'Technician',
            ]);
        }

        if (!User::where('username', 'teknisi-2')->exists()) {
            User::create([
                'name' => 'Teknisi Alif',
                'username' => 'teknisi-2',
                'email' => 'teknisi-2@localhost',
                'password' => Hash::make('tech$777'), 
                'role' => 'Technician',
            ]);
        }

        if (!User::where('username', 'piket')->exists()) {
            User::create([
                'name' => 'Piket',
                'username' => 'piket',
                'email' => 'piket@localhost',
                'password' => Hash::make('piket$123'), 
                'role' => 'Piket',
            ]);
        }
    }
}
