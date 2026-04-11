<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Seminar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seminar>
 */
class SeminarFactory extends Factory
{
    protected $model = Seminar::class;

    public function definition(): array
    {
        return [
            'nim' => Mahasiswa::factory(),
            'judul' => $this->faker->sentence(),
            'pembimbing1_id' => Dosen::factory(),
            'pembimbing2_id' => Dosen::factory(),
            'tanggal' => now()->addDays(7),
            'tempat' => 'Ruang Seminar 1',
            'acc_seminar' => null,
            'notifikasi_whatsapp' => false,
        ];
    }
}
