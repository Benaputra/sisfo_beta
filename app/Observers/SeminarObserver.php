<?php

namespace App\Observers;

use App\Models\Seminar;
use App\Models\Skripsi;

class SeminarObserver
{
    /**
     * Handle the Seminar "updated" event.
     */
    public function updated(Seminar $seminar): void
    {
        // Mengecek apakah status acc_seminar berubah
        if ($seminar->wasChanged('acc_seminar')) {
            
            if ($seminar->acc_seminar === 'Disetujui') {
                // Jika status menjadi 'Disetujui', pastikan data skripsi dibuat jika belum ada
                Skripsi::firstOrCreate(
                    ['nim' => $seminar->nim],
                    [
                        'judul' => $seminar->judul,
                        'pembimbing1_id' => $seminar->pembimbing1_id,
                        'pembimbing2_id' => $seminar->pembimbing2_id,
                        'tanggal' => now(), 
                        'tempat' => '-',
                        'notifikasi_whatsapp' => false,
                    ]
                );
            } 
            elseif ($seminar->getOriginal('acc_seminar') === 'Disetujui' && $seminar->acc_seminar !== 'Disetujui') {
                // Jika sebelumnya 'Disetujui' tapi sekarang dibatalkan (Ditolak/Menunggu), hapus data skripsi
                Skripsi::where('nim', $seminar->nim)->delete();
            }
        }
    }
}
