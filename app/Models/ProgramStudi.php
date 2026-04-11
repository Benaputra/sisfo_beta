<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $table = 'program_studi';

    protected $fillable = [
        'nama',
        'ketua_prodi',
        'ttd_ketua_prodi',
    ];

    /**
     * Relasi ke Dosen yang menjabat sebagai Ketua Prodi
     */
    public function ketuaProdi(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'ketua_prodi');
    }

    /**
     * Relasi ke semua Mahasiswa di bawah Prodi ini
     */
    public function mahasiswas(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'program_studi_id');
    }

    /**
     * Relasi ke semua Dosen di bawah Prodi ini
     */
    public function dosens(): HasMany
    {
        return $this->hasMany(Dosen::class, 'program_studi_id');
    }
}
