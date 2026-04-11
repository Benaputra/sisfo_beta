<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $token;
    protected string $endpoint;

    public function __construct()
    {
        $this->token    = config('services.wablas.token');
        $this->endpoint = config('services.wablas.endpoint', 'https://console.wablas.com/api/send-message');
    }

    /**
     * Kirim pesan WhatsApp via Wablas.
     *
     * @param  string  $nomor  Nomor HP tujuan (format internasional tanpa +, cth: 6281234567890)
     * @param  string  $pesan  Isi pesan
     * @return bool
     */
    public function send(string $nomor, string $pesan): bool
    {
        // Normalisasi nomor: hapus karakter non-digit, ganti awalan 0 dengan 62
        $nomor = preg_replace('/\D/', '', $nomor);
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        try {
            $response = Http::withoutVerifying() // Bypass SSL di localhost Windows
                ->withHeaders([
                    'Authorization' => $this->token,
                    'Content-Type'  => 'application/json',
                ])->post($this->endpoint, [
                    'phone'   => $nomor,
                    'message' => $pesan,
                ]);

            $body = $response->json();

            // Wablas mengembalikan { status: true } jika berhasil
            if ($response->successful() && ($body['status'] ?? false) === true) {
                Log::info("Wablas: Pesan terkirim ke {$nomor}");
                return true;
            }

            Log::error('Wablas API Error: ' . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error('WhatsApp Service Exception: ' . $e->getMessage());
            return false;
        }
    }
}
