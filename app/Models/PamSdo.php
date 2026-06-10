<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PamSdo extends Model
{
    // app/Models/PamSdo.php
    protected $fillable = [
        'user_id',
        'nama_kegiatan',
        'kategori_pam',
        'tanggal_kegiatan',
        'lokasi',
        'pelaksana',
        'keterangan',
        'status',            // Aman / Ada Insiden
        'status_verifikasi', // pending / disetujui / ditolak
        'foto_dokumentasi',
        'batas_waktu',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date', // Aku tambahkan ini juga biar format tanggalnya otomatis
        'batas_waktu' => 'date',
        'keterangan' => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
