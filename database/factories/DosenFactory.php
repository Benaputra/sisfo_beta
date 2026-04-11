<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dosen>
 */
class DosenFactory extends Factory
{
    protected $model = Dosen::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nidn' => $this->faker->unique()->numerify('0012######'),
            'program_studi_id' => ProgramStudi::factory(),
            'jabatan_fungsional' => 'Asisten Ahli',
        ];
    }
}
