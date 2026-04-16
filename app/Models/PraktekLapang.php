<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PraktekLapang extends Model
{
    use HasFactory;

    protected $table = 'praktek_lapangs';

    protected $fillable = [
        'nim',
        'laporan',
        'lokasi',
        'bukti_bayar',
        'dosen_pembimbing_id',
        'surat_id',
        'notifikasi_whatsapp',
    ];

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    /**
     * Relasi ke Dosen Pembimbing Lapangan
     */
    public function dosenPembimbing(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_id');
    }

    /**
     * Relasi ke Surat Tugas/Pengantar
     */
    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }

    /**
     * Cek kelengkapan file (Bukti Bayar)
     */
    public function canGenerateSurat(): bool
    {
        return !empty($this->bukti_bayar);
    }
}
