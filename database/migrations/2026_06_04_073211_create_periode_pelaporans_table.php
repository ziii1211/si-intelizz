<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('periode_pelaporans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_buka')->nullable();
            $table->date('tanggal_tutup')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('periode_pelaporans');
    }
};