<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Akun', 'slug' => 'akun'],
            ['name' => 'Aplikasi', 'slug' => 'aplikasi'],
            ['name' => 'Pengaduan', 'slug' => 'pengaduan'],
            ['name' => 'Tiket', 'slug' => 'tiket'],
            ['name' => 'Jaringan', 'slug' => 'jaringan'],
            ['name' => 'Software', 'slug' => 'software'],
            ['name' => 'Hardware', 'slug' => 'hardware'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
