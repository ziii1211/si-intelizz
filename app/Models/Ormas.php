<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ormas extends Model
{
    protected $fillable = [
        'user_id',
        'nama_organisasi',
        'nama_pimpinan', 
        'alamat_sekretariat',
        'bentuk_organisasi',
        'status_legalitas',
        'nomor_sk',
        'kegiatan_utama',
        'jumlah_anggota',
        'afiliasi',
        'status_pengawasan',
        'status_verifikasi',
        'batas_waktu', // <--- Tambahan Batas Waktu
        'foto_lambang'
    ];

    protected $casts = [
        'batas_waktu' => 'date', // Otomatis format tanggal
        
        // Enkripsi data sensitif (Yang tidak dipakai buat Search)
        'alamat_sekretariat' => 'encrypted',
        'kegiatan_utama' => 'encrypted',
        'afiliasi' => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}