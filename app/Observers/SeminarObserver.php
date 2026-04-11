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
        // Jika file ACC seminar baru saja diunggah (dianggap 'Lulus')
        if ($seminar->wasChanged('acc_seminar') && !empty($seminar->acc_seminar)) {
            
            // Cek apakah data skripsi sudah ada untuk mahasiswa ini agar tidak duplikat
            $exists = Skripsi::where('nim', $seminar->nim)->exists();

            if (!$exists) {
                Skripsi::create([
                    'nim' => $seminar->nim,
                    'judul' => $seminar->judul, // Biasanya skripsi melanjutkan judul seminar
                    'pembimbing1_id' => $seminar->pembimbing1_id,
                    'pembimbing2_id' => $seminar->pembimbing2_id,
                    'tanggal' => now(), // Placeholder, bisa diubah nanti oleh admin
                    'tempat' => '-',
                    'notifikasi_whatsapp' => false,
                ]);
            }
        }
    }
}
