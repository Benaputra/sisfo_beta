<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $token;
    protected string $endpoint = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
    }

    /**
     * Kirim pesan WhatsApp via Fonnte
     */
    public function send(string $nomor, string $pesan): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->endpoint, [
                'target' => $nomor,
                'message' => $pesan,
                'delay' => '2', // Jeda antar pesan agar tidak diblokir
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('Fonnte API Error: ' . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error('WhatsApp Service Exception: ' . $e->getMessage());
            return false;
        }
    }
}
