<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wna extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'negara_asal',
        'nomor_paspor',
        'tujuan_kunjungan',
        'sponsor',
        'tempat_tinggal',
        'masa_berlaku_izin',
        'status_verifikasi',
        'foto'
    ];

    protected $casts = [
        // Perbaikan format tanggal agar otomatis jadi objek Carbon
        'tanggal_lahir' => 'date',
        'masa_berlaku_izin' => 'date', 
        
        // Enkripsi data tingkat tinggi
        'nomor_paspor' => 'encrypted',
        'tempat_tinggal' => 'encrypted',
        'tujuan_kunjungan' => 'encrypted',
        'sponsor' => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}