<?php

namespace App\Policies;

use App\Models\ProgramStudi;
use App\Models\User;

class ProgramStudiPolicy
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
    public function view(User $user, ProgramStudi $programStudi): bool
    {
        return $user->hasAnyRole(['admin', 'staff', 'kaprodi']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProgramStudi $programStudi): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProgramStudi $programStudi): bool
    {
        return $user->hasPermissionTo('delete-data');
    }
}
