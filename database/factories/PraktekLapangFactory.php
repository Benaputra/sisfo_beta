<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\PraktekLapang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PraktekLapang>
 */
class PraktekLapangFactory extends Factory
{
    protected $model = PraktekLapang::class;

    public function definition(): array
    {
        return [
            'nim' => Mahasiswa::factory(),
            'lokasi' => $this->faker->company(),
            'dosen_pembimbing_id' => Dosen::factory(),
        ];
    }
}
