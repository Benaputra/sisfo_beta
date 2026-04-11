<?php

namespace App\Policies;

use App\Models\Skripsi;
use App\Models\User;

class SkripsiPolicy
{
    public function viewAny(User $user): bool { return true; }

    public function view(User $user, Skripsi $skripsi): bool {
        if ($user->hasAnyRole(['admin', 'staff', 'kaprodi'])) return true;
        if ($user->hasRole('dosen')) {
            return $user->id === $skripsi->pembimbing1_id || $user->id === $skripsi->pembimbing2_id;
        }
        return $user->nim === $skripsi->nim;
    }

    public function create(User $user): bool {
        // Skripsi biasanya dibuat otomatis oleh Observer, tapi admin bisa create manual
        return $user->hasAnyRole(['admin', 'staff', 'kaprodi']);
    }

    public function update(User $user, Skripsi $skripsi): bool {
        if ($user->hasAnyRole(['admin', 'staff', 'kaprodi'])) return true;
        if ($user->hasRole('mahasiswa') && $user->nim === $skripsi->nim) return true;
        return false;
    }

    public function delete(User $user, Skripsi $skripsi): bool {
        return $user->hasPermissionTo('delete-data');
    }
}
