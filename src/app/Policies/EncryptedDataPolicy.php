<?php

namespace App\Policies;

use App\Models\EncryptedData;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EncryptedDataPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function view(User $user, EncryptedData $encryptedData): bool
    {
        return $user->hasRole('super_admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function update(User $user, EncryptedData $encryptedData): bool
    {
        return $user->hasRole('super_admin');
    }

    public function delete(User $user, EncryptedData $encryptedData): bool
    {
        return $user->hasRole('super_admin');
    }
}