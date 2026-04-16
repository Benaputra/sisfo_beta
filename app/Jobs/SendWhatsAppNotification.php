<?php

namespace App\Jobs;

use App\Models\Seminar;
use App\Models\Skripsi;
use App\Models\PraktekLapang;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [60, 300, 900];

    protected $model;
    protected string $type;
    protected ?string $customMessage;

    /**
     * Create a new job instance.
     */
    public function __construct($model, string $type, ?string $customMessage = null)
    {
        $this->model = $model;
        $this->type = $type;
        $this->customMessage = $customMessage;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $waService): void
    {
        $mahasiswa = $this->model->mahasiswa;
        $nomor = $mahasiswa->no_hp;

        if (!$nomor) return;
        
        $pesan = $this->customMessage ?? $this->generateMessage($mahasiswa->nama);

        $success = $waService->send($nomor, $pesan);

        if ($success) {
            $this->model->update(['notifikasi_whatsapp' => true]);
        } else {
            // Jika gagal, job akan di-retry sesuai setting $tries
            $this->fail();
        }
    }

    /**
     * Template Pesan
     */
    protected function generateMessage(string $nama): string
    {
        $jenis = match ($this->type) {
            'seminar' => 'seminar',
            'skripsi' => 'skripsi',
            'praktek_lapang' => 'praktek lapang',
            default => 'akademik',
        };

        return "Yth. $nama, surat undangan $jenis Anda telah tersedia. Silakan login ke sistem untuk mengunduh.";
    }
}
