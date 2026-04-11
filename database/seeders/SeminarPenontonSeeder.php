<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\SeminarPenonton;
use Illuminate\Database\Seeder;

class SeminarPenontonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswas = Mahasiswa::all();
        
        // 5 Mahasiswa siap daftar (12x nonton)
        $siapDaftar = $mahasiswas->take(5);
        foreach ($siapDaftar as $mhs) {
            for ($i = 0; $i < 12; $i++) {
                SeminarPenonton::create([
                    'nim' => $mhs->nim,
                    'tanggal_nonton' => now()->subDays(rand(1, 30)),
                ]);
            }
        }

        // 5 Mahasiswa lainnya (3-8x nonton)
        $sisanya = $mahasiswas->slice(5, 5);
        foreach ($sisanya as $mhs) {
            $count = rand(3, 8);
            for ($i = 0; $i < $count; $i++) {
                SeminarPenonton::create([
                    'nim' => $mhs->nim,
                    'tanggal_nonton' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
