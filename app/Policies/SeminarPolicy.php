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
            $dosenId = $user->dosen?->id;
            return $dosenId && (
                $dosenId === $seminar->pembimbing1_id || 
                $dosenId === $seminar->pembimbing2_id || 
                $dosenId === $seminar->penguji_seminar_id
            );
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
