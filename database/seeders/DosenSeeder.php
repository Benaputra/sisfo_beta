<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $prodis = ProgramStudi::all();
        $jabatans = ['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'];

        for ($i = 0; $i < 10; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            
            Dosen::create([
                'nama' => $faker->name($gender),
                'nidn' => '00' . $faker->unique()->numberBetween(10000000, 99999999),
                'nuptk' => '9' . $faker->numberBetween(10000000, 99999999),
                'program_studi_id' => $prodis->random()->id,
                'no_hp' => '081' . $faker->numberBetween(10000000, 99999999),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '1990-01-01'),
                'jabatan_fungsional' => $faker->randomElement($jabatans),
            ]);
        }

        // Assign Ketua Prodi
        foreach ($prodis as $prodi) {
            $dosen = Dosen::where('program_studi_id', $prodi->id)->first();
            if ($dosen) {
                $prodi->update(['ketua_prodi' => $dosen->id]);
            }
        }
    }
}
