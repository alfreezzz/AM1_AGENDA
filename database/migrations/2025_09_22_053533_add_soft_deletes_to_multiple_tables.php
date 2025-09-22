<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('jurusans', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('data_siswas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('agendas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('absen_gurus', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('absen_siswas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('absensiswa__gurus', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('data_gurus', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('jurusans', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('data_siswas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('agendas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('absen_gurus', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('absen_siswas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('absensiswa__gurus', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('data_gurus', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
