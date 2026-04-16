<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanJudul extends Model
{
    protected $table = 'pengajuan_juduls';

    protected $fillable = [
        'nim',
        'judul',
        'bukti_bayar',
        'no_surat',
        'surat_kesediaan',
        'file_kesediaan',
        'is_kesediaan_valid',
        'surat_id',
        'status',
        'keterangan',
        'pembimbing1_id',
        'pembimbing2_id',
    ];

    protected $casts = [
        'is_kesediaan_valid' => 'boolean',
        'tanggal' => 'date',
    ];

    /**
     * Cek apakah surat kesediaan bimbingan bisa diunduh.
     * Syarat: Pembimbing 1 dan Bukti Bayar sudah ada.
     */
    public function canDownloadKesediaan(): bool
    {
        return !empty($this->pembimbing1_id) && !empty($this->bukti_bayar);
    }

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    /**
     * Relasi ke Dosen (Pembimbing 1)
     */
    public function pembimbing1()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing1_id');
    }

    /**
     * Relasi ke Dosen (Pembimbing 2)
     */
    public function pembimbing2()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing2_id');
    }

    /**
     * Relasi ke Dosen (Penguji)
     */
    public function penguji()
    {
        return $this->belongsTo(Dosen::class, 'penguji_id');
    }

    /**
     * Relasi ke Surat
     */
    public function surat()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }
}
