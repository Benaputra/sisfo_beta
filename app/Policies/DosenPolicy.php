<?php

namespace App\Policies;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DosenPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'staff', 'kaprodi', 'dosen']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Dosen $dosen): bool
    {
        if ($user->hasAnyRole(['admin', 'staff', 'kaprodi'])) return true;

        if ($user->hasRole('dosen')) {
            return $user->dosen?->program_studi_id === $dosen->program_studi_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Dosen $dosen): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Dosen $dosen): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Dosen $dosen): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Dosen $dosen): bool
    {
        return false;
    }
}
