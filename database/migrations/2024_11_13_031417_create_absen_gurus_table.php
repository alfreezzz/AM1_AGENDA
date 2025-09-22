<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absen_gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tgl');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('keterangan');
            $table->string('tugas')->nullable();
            $table->string('keterangantugas');
            $table->unsignedBigInteger('added_by')->nullable(); // Tambahkan kolom di sini
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade'); // Tambahkan relasi
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen_gurus');
    }
};
