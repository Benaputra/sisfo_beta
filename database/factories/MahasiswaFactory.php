<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    public function definition(): array
    {
        return [
            'nim' => $this->faker->unique()->numerify('25103#####'),
            'nama' => $this->faker->name(),
            'program_studi_id' => ProgramStudi::factory(),
            'no_hp' => '08' . $this->faker->numerify('##########'),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => '2005-01-01',
            'angkatan' => 2025,
            'pembimbing_akademik' => Dosen::factory(),
        ];
    }
}
