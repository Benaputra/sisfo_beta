<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodis = [
            ['nama' => 'Agroteknologi'],
            ['nama' => 'Agribisnis'],
        ];

        foreach ($prodis as $prodi) {
            ProgramStudi::create($prodi);
        }
    }
}
