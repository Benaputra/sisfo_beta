<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@fpst.upb.ac.id',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // 2. Staff
        $staff = User::create([
            'name' => 'Staff Akademik',
            'email' => 'staff@fpst.upb.ac.id',
            'password' => Hash::make('password'),
        ]);
        $staff->assignRole('staff');

        // 3. Dosens
        $dosens = Dosen::all();
        foreach ($dosens as $dosen) {
            $user = User::create([
                'name' => $dosen->nama,
                'email' => "{$dosen->nidn}@fpst.upb.ac.id",
                'password' => Hash::make('password'),
                'nidn' => $dosen->nidn,
            ]);
            
            // Cek apakah dia Kaprodi
            $isKaprodi = \App\Models\ProgramStudi::where('ketua_prodi', $dosen->id)->exists();
            if ($isKaprodi) {
                $user->assignRole('kaprodi');
            } else {
                $user->assignRole('dosen');
            }
        }

        // 4. Mahasiswas
        $mahasiswas = Mahasiswa::all();
        foreach ($mahasiswas as $mhs) {
            $user = User::create([
                'name' => $mhs->nama,
                'email' => "{$mhs->nim}@fpst.upb.ac.id",
                'password' => Hash::make('password'),
                'nim' => $mhs->nim,
            ]);
            $user->assignRole('mahasiswa');
        }
    }
}
