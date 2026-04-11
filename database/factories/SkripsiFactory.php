<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Skripsi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skripsi>
 */
class SkripsiFactory extends Factory
{
    protected $model = Skripsi::class;

    public function definition(): array
    {
        return [
            'nim' => Mahasiswa::factory(),
            'judul' => $this->faker->sentence(),
            'pembimbing1_id' => Dosen::factory(),
            'pembimbing2_id' => Dosen::factory(),
            'tanggal' => now()->addMonths(6),
            'tempat' => 'Ruang Sidang',
        ];
    }
}
