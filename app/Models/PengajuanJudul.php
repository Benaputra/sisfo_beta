<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanJudul extends Model
{
    protected $table = 'pengajuan_judul';

    protected $fillable = [
        'nim',
        'judul',
        'bukti_bayar',
        'no_surat',
        'surat_kesediaan',
        'status',
        'keterangan',
        'pembimbing1_id',
        'pembimbing2_id',
    ];

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
}
