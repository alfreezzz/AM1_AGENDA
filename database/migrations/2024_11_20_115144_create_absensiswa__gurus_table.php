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
        Schema::create('absensiswa__gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tgl');
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('nis_id')->constrained('data_siswas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('keterangan');
            $table->unsignedBigInteger('added_by')->nullable(); // Tambahkan kolom di sini
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade'); // Tambahkan relasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensiswa__gurus');
    }
};
