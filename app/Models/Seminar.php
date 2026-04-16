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
        'pengajuan_judul_id',
        'nim',
        'judul',
        'pembimbing1_id',
        'pembimbing2_id',
        'penguji_seminar_id',
        'tanggal',
        'tempat',
        'bukti_bayar',
        'acc_seminar',
        'file_kesediaan',
        'is_kesediaan_valid',
        'surat_kesediaan_id',
        'surat_undangan_id',
        'notifikasi_whatsapp',
        'keterangan',
    ];

    /**
     * Relasi ke Pengajuan Judul
     */
    public function pengajuanJudul(): BelongsTo
    {
        return $this->belongsTo(PengajuanJudul::class, 'pengajuan_judul_id');
    }

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
     * Cek apakah surat kesediaan seminar bisa diunduh.
     * Syarat: Pembimbing 1 dan Bukti Bayar sudah diisi oleh staff.
     */
    public function canDownloadKesediaan(): bool
    {
        return !empty($this->pembimbing1_id) 
            && !empty($this->bukti_bayar);
    }

    /**
     * Cek kelengkapan data untuk generate surat undangan seminar
     * Syarat baru: Surat Kesediaan harus sudah di-upload dan divalidasi oleh staff.
     */
    public function canGenerateSurat(): bool
    {
        return $this->acc_seminar === 'Disetujui' 
            && !empty($this->bukti_bayar)
            && !empty($this->pembimbing1_id)
            && !empty($this->pembimbing2_id)
            && !empty($this->penguji_seminar_id)
            && $this->is_kesediaan_valid; // Ditambahkan syarat validasi kesediaan
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
}
