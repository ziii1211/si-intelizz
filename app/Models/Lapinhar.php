<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lapinhar extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_surat',
        'tanggal_surat',
        'sumber_informasi',
        'bidang',
        'peristiwa',
        'pendapat',
        'status',
        'status_verifikasi',
        'tanggal_dibuka',
        'tanggal_ditutup',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'peristiwa' => 'encrypted', // Data otomatis dienkripsi di database
        'pendapat' => 'encrypted',  // Data otomatis dienkripsi di database
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
