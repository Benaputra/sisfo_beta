<?php

namespace App\Console\Commands;

use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class TestWablasConnection extends Command
{
    /**
     * Nama command yang dijalankan di terminal.
     * Contoh: php artisan wablas:test 6281234567890
     */
    protected $signature = 'wablas:test {nomor : Nomor HP tujuan (cth: 6281234567890 atau 081234567890)}';

    protected $description = 'Uji koneksi ke Wablas API dengan mengirim pesan tes ke nomor tertentu';

    public function handle(WhatsAppService $waService): int
    {
        $nomor = $this->argument('nomor');

        $this->info("=== Test Koneksi Wablas ===");
        $this->line("Token   : " . (config('services.wablas.token') ? '✅ Terkonfigurasi' : '❌ BELUM DIISI'));
        $this->line("Endpoint: " . config('services.wablas.endpoint'));
        $this->line("Nomor   : {$nomor}");
        $this->newLine();

        if (!config('services.wablas.token') || config('services.wablas.token') === 'your_wablas_token_here') {
            $this->error("❌ WABLAS_TOKEN belum diisi di file .env!");
            $this->line("   Buka file .env dan isi: WABLAS_TOKEN=token_anda");
            return Command::FAILURE;
        }

        $this->info("📤 Mengirim pesan tes...");

        $pesan = "✅ Halo! Ini adalah pesan uji coba dari Sistem Informasi Akademik FPST.\n"
               . "Jika Anda menerima pesan ini, konfigurasi WhatsApp Gateway (Wablas) berhasil.\n"
               . "Waktu: " . now()->format('d/m/Y H:i:s');

        $sukses = $waService->send($nomor, $pesan);

        if ($sukses) {
            $this->info("✅ BERHASIL! Pesan terkirim ke nomor {$nomor}.");
            $this->line("   Cek WhatsApp nomor tersebut untuk memverifikasi.");
        } else {
            $this->error("❌ GAGAL mengirim pesan. Cek log di storage/logs/laravel.log untuk detail error.");
            $this->line("   Kemungkinan penyebab:");
            $this->line("   1. Token salah atau kadaluarsa");
            $this->line("   2. Device Wablas tidak terhubung (scan QR code di dashboard Wablas)");
            $this->line("   3. Endpoint URL tidak sesuai dengan server Wablas Anda");
            $this->line("   4. Nomor HP tidak valid");
        }

        return $sukses ? Command::SUCCESS : Command::FAILURE;
    }
}
