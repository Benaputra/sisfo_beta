<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $prodis = ProgramStudi::all();
        $dosens = Dosen::all();

        for ($i = 0; $i < 20; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $angkatan = $faker->numberBetween(2020, 2025);
            
            Mahasiswa::create([
                'nim' => $angkatan . $faker->unique()->numberBetween(10000, 99999),
                'nama' => $faker->name($gender),
                'program_studi_id' => $prodis->random()->id,
                'no_hp' => '085' . $faker->numberBetween(10000000, 99999999),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2005-01-01'),
                'angkatan' => $angkatan,
                'pembimbing_akademik' => $dosens->random()->id,
            ]);
        }
    }
}
