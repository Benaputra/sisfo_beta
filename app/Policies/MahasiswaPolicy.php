<?php

namespace App\Policies;

use App\Models\Mahasiswa;
use App\Models\User;

class MahasiswaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'staff', 'kaprodi']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Mahasiswa $mahasiswa): bool
    {
        if ($user->hasAnyRole(['admin', 'staff', 'kaprodi'])) return true;
        
        if ($user->hasRole('dosen')) {
            return $user->dosen?->program_studi_id === $mahasiswa->program_studi_id;
        }

        return $user->nim === $mahasiswa->nim;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'staff']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Mahasiswa $mahasiswa): bool
    {
        if ($user->hasAnyRole(['admin', 'staff'])) return true;
        return $user->nim === $mahasiswa->nim;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Mahasiswa $mahasiswa): bool
    {
        return $user->hasPermissionTo('delete-data');
    }
}
