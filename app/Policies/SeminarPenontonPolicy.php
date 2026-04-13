<?php

namespace App\Policies;

use App\Models\SeminarPenonton;
use App\Models\User;

class SeminarPenontonPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin, Staff, Kaprodi can see the list. 
        // Mahasiswa might need access if they register via a Resource,
        // but typically registration is handled via an action or custom page.
        // Based on user request to restrict, we limit this to staff roles.
        return $user->hasAnyRole(['admin', 'staff', 'kaprodi']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SeminarPenonton $seminarPenonton): bool
    {
        if ($user->hasAnyRole(['admin', 'staff', 'kaprodi'])) return true;
        return $user->nim === $seminarPenonton->nim;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['register-nonton-seminar', 'manage-all-seminar']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SeminarPenonton $seminarPenonton): bool
    {
        return $user->hasAnyRole(['admin', 'staff']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SeminarPenonton $seminarPenonton): bool
    {
        return $user->hasPermissionTo('delete-data');
    }
}
