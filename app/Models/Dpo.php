<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dpo extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'kasus',
        'status_hukum',
        'ciri_fisik',
        'foto',
        'status_pencarian',
        'status_verifikasi',
        'batas_waktu',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'batas_waktu' => 'date',
        'kasus' => 'encrypted',
        'ciri_fisik' => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
