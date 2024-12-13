<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('subjek');
            $table->string('permasalahan_id');
            $table->string('satker');
            $table->string('prioritas');
            $table->string('area');
            $table->text('pesan');
            $table->string('lampiran')->nullable();
            $table->enum('status_id', [1, 2, 3, 4]);
            $table->integer('rating')->nullable();
            $table->text('rating_comment')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('technician_id')->nullable();
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
