<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Definisikan Permission berdasarkan kategori
        $permissions = [
            // Mahasiswa
            'view-own-seminar',
            'create-seminar',
            'create-skripsi',
            'create-praktek-lapang',
            'register-nonton-seminar',

            // Dosen
            'view-own-skripsi',
            'view-own-pl',
            'update-own-profil',

            // Staff & Manajemen
            'manage-all-seminar',
            'manage-all-skripsi',
            'manage-all-pl',
            'generate-surat-tanpa-ttd',
            'manage-no-surat',

            // Kaprodi
            'generate-surat-dengan-ttd',

            // Admin
            'delete-data',
            'upload-ttd-kaprodi',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // 2. Buat Role dan Assign Permission
        
        // MAHASISWA
        Role::findOrCreate('mahasiswa')->givePermissionTo([
            'view-own-seminar',
            'create-seminar',
            'create-skripsi',
            'create-praktek-lapang',
            'register-nonton-seminar',
        ]);

        // DOSEN
        Role::findOrCreate('dosen')->givePermissionTo([
            'view-own-seminar', // Dosen bisa lihat seminar bimbingannya
            'view-own-skripsi',
            'view-own-pl',
            'update-own-profil',
        ]);

        // STAFF
        $staffRole = Role::findOrCreate('staff');
        $staffRole->givePermissionTo([
            'view-own-seminar',
            'view-own-skripsi', // legacy or generalized permissions
            'manage-all-seminar',
            'manage-all-skripsi',
            'manage-all-pl',
            'generate-surat-tanpa-ttd',
            'manage-no-surat',
        ]);

        // KAPRODI (Bisa semua yang staff bisa + tambahan)
        $kaprodiRole = Role::findOrCreate('kaprodi');
        $kaprodiRole->syncPermissions($staffRole->permissions);
        $kaprodiRole->givePermissionTo('generate-surat-dengan-ttd');

        // ADMIN (Super User)
        Role::findOrCreate('admin')->givePermissionTo(Permission::all());
    }
}
