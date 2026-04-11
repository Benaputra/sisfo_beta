<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'nama',
        'program_studi_id',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'angkatan',
        'pembimbing_akademik',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'angkatan' => 'integer',
    ];

    /**
     * Relasi ke Program Studi
     */
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    /**
     * Relasi ke Dosen (Pembimbing Akademik)
     */
    public function pembimbingAkademik(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_akademik');
    }

    /**
     * Relasi ke Seminar
     */
    public function seminar(): HasOne
    {
        return $this->hasOne(Seminar::class, 'nim', 'nim');
    }

    /**
     * Relasi ke Skripsi
     */
    public function skripsi(): HasOne
    {
        return $this->hasOne(Skripsi::class, 'nim', 'nim');
    }

    /**
     * Relasi ke Praktek Lapang (Multiple)
     */
    public function praktekLapang(): HasMany
    {
        return $this->hasMany(PraktekLapang::class, 'nim', 'nim');
    }

    /**
     * Relasi ke Seminar yang ditonton (Multiple)
     */
    public function seminarPenonton(): HasMany
    {
        return $this->hasMany(SeminarPenonton::class, 'nim', 'nim');
    }
}
