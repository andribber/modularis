<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function contract(User $user, Tenant $tenant): bool
    {
        return $tenant->canAdmin($user);
    }

    public function view(User $user, Tenant $tenant): bool
    {
        return $tenant->is($user->tenants()->wherePivot('tenant_id', $tenant->id)->first());
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Tenant $tenant): bool
    {
        return $tenant->is($user->tenants()->wherePivot('tenant_id', $tenant->id)->first());
    }

    public function delete(User $user, Tenant $tenant): bool
    {
        return $tenant->isOwner($user) && ! $tenant->has_personal;
    }

    public function viewUsers(User $user, Tenant $tenant): bool
    {
        return $tenant->is($user->tenants()->wherePivot('tenant_id', $tenant->id)->first());
    }

    public function attachUser(User $user): bool
    {
        return true;
    }

    public function updateRole(User $user, Tenant $tenant, User $target): bool
    {
        return ($tenant->isPersonal($user) || $tenant->isOwner($user) || $tenant->isAdmin($user))
            && ! $tenant->isPersonal($target)
            && ! $tenant->isOwner($target)
            && $tenant->is($user->tenants()->wherePivot('tenant_id', $tenant->id)->first());
    }

    public function detachUser(User $user, Tenant $tenant, User $target): bool
    {
        return ($tenant->isPersonal($user) || $tenant->isOwner($user) || $tenant->isAdmin($user))
            && ! $tenant->isPersonal($target)
            && ! $tenant->isOwner($target)
            && $tenant->is($user->tenants()->wherePivot('tenant_id', $tenant->id)->first());
    }

    public function viewBalance(User $user, Tenant $tenant): bool
    {
        return $tenant->is($user->tenants()->wherePivot('tenant_id', $tenant->id)->first());
    }
}
