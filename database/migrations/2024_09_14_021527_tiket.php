<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket', function (Blueprint $table) { // Ubah menjadi 'tikets' sesuai standar penamaan tabel plural
            $table->id();
            $table->date('tanggal');
            $table->string('subjek');
            $table->string('permasalahan');
            $table->string('satker'); // Bisa diganti dengan unsignedBigInteger jika ini foreign key
            $table->string('prioritas');
            $table->string('area');
            $table->text('pesan');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['Diproses', 'Selesai', 'Ditutup'])->default('Diproses'); // Enum untuk membatasi pilihan status
            $table->integer('rating')->nullable();
            $table->text('rating_comment')->nullable();
            $table->unsignedBigInteger('created_by'); // Foreign key to users table
            $table->unsignedBigInteger('technician_id')->nullable(); // Foreign key untuk teknisi
            $table->timestamps();
            $table->softDeletes();

            // Tambahkan foreign key constraint
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('technician_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket');
    }
};
