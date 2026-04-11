<?php

namespace App\Policies;

use App\Models\PraktekLapang;
use App\Models\User;

class PraktekLapangPolicy
{
    public function viewAny(User $user): bool { return true; }

    public function view(User $user, PraktekLapang $pl): bool {
        if ($user->hasAnyRole(['admin', 'staff', 'kaprodi'])) return true;
        if ($user->hasRole('dosen')) return $user->id === $pl->dosen_pembimbing_id;
        return $user->nim === $pl->nim;
    }

    public function create(User $user): bool {
        return $user->hasAnyPermission(['create-praktek-lapang', 'manage-all-pl']);
    }

    public function update(User $user, PraktekLapang $pl): bool {
        if ($user->hasAnyRole(['admin', 'staff', 'kaprodi'])) return true;
        
        // Mahasiswa TIDAK bisa edit setelah submit (return false)
        return false;
    }

    public function delete(User $user, PraktekLapang $pl): bool {
        return $user->hasPermissionTo('delete-data');
    }
}
