<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'nama',
        'nidn',
        'nuptk',
        'program_studi_id',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'jabatan_fungsional',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke Program Studi asal
     */
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    /**
     * Relasi ke Mahasiswa sebagai Pembimbing Akademik
     */
    public function mahasiswaBimbinganAkademik(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'pembimbing_akademik');
    }

    /**
     * Relasi sebagai Ketua Prodi
     */
    public function jabatanKetuaProdi(): HasOne
    {
        return $this->hasOne(ProgramStudi::class, 'ketua_prodi');
    }

    // --- Relasi Seminar ---
    public function seminarPembimbing1(): HasMany
    {
        return $this->hasMany(Seminar::class, 'pembimbing1_id');
    }

    public function seminarPembimbing2(): HasMany
    {
        return $this->hasMany(Seminar::class, 'pembimbing2_id');
    }

    public function seminarPenguji1(): HasMany
    {
        return $this->hasMany(Seminar::class, 'penguji_seminar_id');
    }

    public function seminarPenguji2(): HasMany
    {
        return $this->hasMany(Seminar::class, 'penguji2_id');
    }

    // --- Relasi Skripsi ---
    public function skripsiPembimbing1(): HasMany
    {
        return $this->hasMany(Skripsi::class, 'pembimbing1_id');
    }

    public function skripsiPembimbing2(): HasMany
    {
        return $this->hasMany(Skripsi::class, 'pembimbing2_id');
    }

    public function skripsiPenguji1(): HasMany
    {
        return $this->hasMany(Skripsi::class, 'penguji1_id');
    }

    public function skripsiPenguji2(): HasMany
    {
        return $this->hasMany(Skripsi::class, 'penguji2_id');
    }

    /**
     * Relasi ke Praktek Lapang sebagai Dosen Pembimbing
     */
    public function praktekLapangBimbingan(): HasMany
    {
        return $this->hasMany(PraktekLapang::class, 'dosen_pembimbing_id');
    }
}
