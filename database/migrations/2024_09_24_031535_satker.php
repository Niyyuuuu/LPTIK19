<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_satker', function (Blueprint $table) {
            $table->id();
            $table->string('nama_satker');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_satker');  // Perbaikan: Menambahkan drop jika tabel ada
    }
};
