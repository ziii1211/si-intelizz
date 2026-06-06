<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PeriodePelaporan extends Model
{
    protected $guarded = [];

    // Gunakan fungsi ini untuk mengecek secara global di semua menu
    public static function isAktif()
    {
        $periode = self::first();
        
        // Jika belum ada data settingan sama sekali, atau tanggal kosong
        if (!$periode || !$periode->tanggal_buka || !$periode->tanggal_tutup) {
            return false; 
        }

        // Pengecekan waktu yang akurat (full 1 hari)
        $now = Carbon::now()->startOfDay();
        $buka = Carbon::parse($periode->tanggal_buka)->startOfDay();
        $tutup = Carbon::parse($periode->tanggal_tutup)->endOfDay(); // Aktif sampai 23:59:59

        return $now->between($buka, $tutup);
    }
}