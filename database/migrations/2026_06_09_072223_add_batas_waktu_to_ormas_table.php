<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ormas', function (Blueprint $table) {
            // Menambahkan kolom batas_waktu di tabel ormas
            $table->date('batas_waktu')->nullable()->after('status_pengawasan');
        });
    }

    public function down(): void
    {
        Schema::table('ormas', function (Blueprint $table) {
            $table->dropColumn('batas_waktu');
        });
    }
};