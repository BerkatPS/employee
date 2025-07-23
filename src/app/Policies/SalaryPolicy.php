<?php

namespace App\Policies;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalaryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin') || $user->hasRole('admin') || $user->hasRole('user');
    }

    public function view(User $user, Salary $salary): bool
    {
        return $user->hasRole('super_admin') || $user->hasRole('admin') || $user->hasRole('user');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin') || $user->hasRole('admin');
    }

    public function update(User $user, Salary $salary): bool
    {
        return $user->hasRole('super_admin') || $user->hasRole('admin');
    }

    public function delete(User $user, Salary $salary): bool
    {
        return $user->hasRole('super_admin') || $user->hasRole('admin');
    }
}