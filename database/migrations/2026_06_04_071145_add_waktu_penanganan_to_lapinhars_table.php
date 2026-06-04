<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('lapinhars', function (Blueprint $table) {
            $table->date('tanggal_dibuka')->nullable()->after('status_verifikasi');
            $table->date('tanggal_ditutup')->nullable()->after('tanggal_dibuka');
        });
    }
    public function down(): void {
        Schema::table('lapinhars', function (Blueprint $table) {
            $table->dropColumn(['tanggal_dibuka', 'tanggal_ditutup']);
        });
    }
};