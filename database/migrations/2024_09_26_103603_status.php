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
            $table->string('status')->default('Diproses');
            $table->timestamps();
        });

        DB::table('status')->insert([
            ['status' => 'Diproses'],
            ['status' => 'Ditutup'],
            ['status' => 'Selesai'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('status');
    }
};