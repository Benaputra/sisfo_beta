<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seminar extends Model
{
    use HasFactory;

    protected $table = 'seminar';

    protected $fillable = [
        'nim',
        'judul',
        'pembimbing1_id',
        'pembimbing2_id',
        'penguji_seminar_id',
        'penguji2_id',
        'tanggal',
        'tempat',
        'bukti_bayar',
        'acc_seminar',
        'surat_undangan_id',
        'notifikasi_whatsapp',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'notifikasi_whatsapp' => 'boolean',
    ];

    /**
     * Relasi ke Mahasiswa pengusul
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    /**
     * Relasi ke Surat Undangan
     */
    public function suratUndangan(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'surat_undangan_id');
    }

    /**
     * Cek kelengkapan file untuk generate surat
     */
    public function canGenerateSurat(): bool
    {
        return !empty($this->acc_seminar) && !empty($this->bukti_bayar);
    }

    // --- Relasi Dosen ---
    public function pembimbing1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'pembimbing1_id');
    }

    public function pembimbing2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'pembimbing2_id');
    }

    public function pengujiSeminar(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'penguji_seminar_id');
    }

    public function penguji2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'penguji2_id');
    }
}
