<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menambah batas waktu ke tabel Lapinhar
        Schema::table('lapinhars', function (Blueprint $table) {
            $table->date('batas_waktu')->nullable()->after('tanggal_surat');
        });

        // Menambah batas waktu ke tabel DPO
        Schema::table('dpos', function (Blueprint $table) {
            $table->date('batas_waktu')->nullable()->after('tanggal_lahir');
        });

        // Menambah batas waktu ke tabel PAM SDO
        Schema::table('pam_sdos', function (Blueprint $table) {
            $table->date('batas_waktu')->nullable()->after('tanggal_kegiatan');
        });
    }

    public function down(): void
    {
        Schema::table('lapinhars', function (Blueprint $table) {
            $table->dropColumn('batas_waktu');
        });
        Schema::table('dpos', function (Blueprint $table) {
            $table->dropColumn('batas_waktu');
        });
        Schema::table('pam_sdos', function (Blueprint $table) {
            $table->dropColumn('batas_waktu');
        });
    }
};