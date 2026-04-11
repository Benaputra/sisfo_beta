<?php

namespace App\Policies;

use App\Models\Seminar;
use App\Models\User;

class SeminarPolicy
{
    public function viewAny(User $user): bool { return true; }

    public function view(User $user, Seminar $seminar): bool {
        if ($user->hasAnyRole(['admin', 'staff', 'kaprodi'])) return true;
        if ($user->hasRole('dosen')) {
            return $user->id === $seminar->pembimbing1_id || $user->id === $seminar->pembimbing2_id;
        }
        return $user->nim === $seminar->nim;
    }

    public function create(User $user): bool {
        return $user->hasAnyPermission(['create-seminar', 'manage-all-seminar']);
    }

    public function update(User $user, Seminar $seminar): bool {
        if ($user->hasAnyRole(['admin', 'staff', 'kaprodi'])) return true;
        
        if ($user->hasRole('mahasiswa') && $user->nim === $seminar->nim) {
            // Mahasiswa diizinkan ke halaman edit, 
            // tapi kita akan disable field via form schema
            return true;
        }

        return false;
    }

    public function delete(User $user, Seminar $seminar): bool {
        return $user->hasPermissionTo('delete-data');
    }
}
