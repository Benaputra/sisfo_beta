<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surats';

    protected $fillable = [
        'jenis_surat',
        'no_surat',
        'tujuan_surat',
        'file_path',
    ];

    /**
     * Relasi ke Seminar yang menggunakan surat ini
     */
    public function seminars(): HasMany
    {
        return $this->hasMany(Seminar::class, 'surat_undangan_id');
    }

    /**
     * Relasi ke Skripsi yang menggunakan surat ini
     */
    public function skripsis(): HasMany
    {
        return $this->hasMany(Skripsi::class, 'surat_undangan_id');
    }

    /**
     * Relasi ke Praktek Lapang yang menggunakan surat ini
     */
    public function praktekLapangs(): HasMany
    {
        return $this->hasMany(PraktekLapang::class, 'surat_id');
    }
}
