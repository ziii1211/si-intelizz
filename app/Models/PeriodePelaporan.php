<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PeriodePelaporan extends Model {
    protected $fillable = ['tanggal_buka', 'tanggal_tutup'];
}