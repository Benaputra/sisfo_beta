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
        'status',
        'surat_kesediaan_id',
        'file_kesediaan',
        'is_kesediaan_valid',
        'surat_undangan_id',
        'pengajuan_judul_id',
        'notifikasi_whatsapp',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'notifikasi_whatsapp' => 'boolean',
        'is_kesediaan_valid' => 'boolean',
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
     * Relasi ke Surat Kesediaan
     */
    public function suratKesediaan(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'surat_kesediaan_id');
    }

    /**
     * Relasi ke Pengajuan Judul
     */
    public function pengajuanJudul(): BelongsTo
    {
        return $this->belongsTo(PengajuanJudul::class, 'pengajuan_judul_id');
    }

    /**
     * Cek kelengkapan file awal
     */
    public function isDataComplete(): bool
    {
        return !empty($this->toefl) && !empty($this->bukti_bayar) && !empty($this->transkrip_nilai);
    }

    /**
     * Cek apakah surat kesediaan sidang bisa diunduh oleh mahasiswa atau divalidasi oleh staff
     * Syarat: Semua file upload lengkap, penguji 1 & 2 ada, tempat ada, dan status disetujui.
     */
    public function canDownloadKesediaan(): bool
    {
        return $this->isDataComplete() 
            && !empty($this->penguji1_id) 
            && !empty($this->penguji2_id) 
            && !empty($this->tempat) 
            && $this->status === 'disetujui';
    }

    /**
     * Cek apakah surat undangan sidang bisa didownload (setelah validasi kesediaan)
     */
    public function canDownloadUndangan(): bool
    {
        return $this->is_kesediaan_valid && $this->surat_undangan_id !== null;
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
