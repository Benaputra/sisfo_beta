<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skripsi extends Model
{
    use HasFactory;

    protected $table = 'skripsi';

    protected $fillable = [
        'nim',
        'judul',
        'pembimbing1_id',
        'pembimbing2_id',
        'penguji1_id',
        'penguji2_id',
        'tanggal',
        'tempat',
        'bukti_bayar',
        'transkrip_nilai',
        'toefl',
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
     * Cek kelengkapan file (TOEFL & Bukti Bayar)
     */
    public function canGenerateSurat(): bool
    {
        return !empty($this->toefl) && !empty($this->bukti_bayar);
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

    public function penguji1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'penguji1_id');
    }

    public function penguji2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'penguji2_id');
    }
}
