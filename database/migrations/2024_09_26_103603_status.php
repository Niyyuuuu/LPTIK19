<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Menunggu');
            $table->timestamps();
        });

        DB::table('status')->insert([
            ['name' => 'Menunggu'],
            ['name' => 'Diproses'],
            ['name' => 'Selesai'],
            ['name' => 'Proses Selesai'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('status');
    }
};