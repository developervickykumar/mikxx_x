<?php

namespace App\Policies;

use App\Models\TableBuilder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TableBuilderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TableBuilder $tableBuilder): bool
    {
        return $tableBuilder->hasPermission($user, 'view');
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, TableBuilder $tableBuilder): bool
    {
        return $tableBuilder->hasPermission($user, 'edit');
    }

    public function delete(User $user, TableBuilder $tableBuilder): bool
    {
        return $tableBuilder->hasPermission($user, 'delete');
    }

    public function restore(User $user, TableBuilder $tableBuilder): bool
    {
        return $tableBuilder->hasPermission($user, 'restore');
    }

    public function forceDelete(User $user, TableBuilder $tableBuilder): bool
    {
        return $tableBuilder->hasPermission($user, 'delete');
    }

    public function duplicate(User $user, TableBuilder $tableBuilder): bool
    {
        return $tableBuilder->hasPermission($user, 'view');
    }

    public function manage(User $user, TableBuilder $tableBuilder): bool
    {
        return $tableBuilder->hasPermission($user, 'manage');
    }

    public function share(User $user, TableBuilder $tableBuilder): bool
    {
        return $tableBuilder->hasPermission($user, 'share');
    }

    public function use(User $user, TableBuilder $tableBuilder): bool
    {
        return $tableBuilder->is_template && $tableBuilder->hasPermission($user, 'view');
    }
} 