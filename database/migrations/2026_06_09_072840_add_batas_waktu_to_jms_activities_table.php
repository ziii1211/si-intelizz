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
        Schema::table('jms_activities', function (Blueprint $table) {
            $table->date('batas_waktu')->nullable()->after('tanggal_kegiatan');
        });
    }

    public function down(): void
    {
        Schema::table('jms_activities', function (Blueprint $table) {
            $table->dropColumn('batas_waktu');
        });
    }
};
