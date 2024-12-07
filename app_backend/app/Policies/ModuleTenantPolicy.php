<?php

namespace App\Policies;

use App\Models\Module;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ModuleTenantPolicy
{
    public function access(User $user, Tenant $tenant, Module $module)
    {
        return $tenant->modules()
            ->where('modules.id', $module->id)
            ->whereHas(
                'moduleTenant',
                fn (Builder $query) => $query->where('module_tenant.expires_at', '>=', now()),
            )->exists()
            && $tenant->canAccess($user)
            && ($tenant->isOwner($user)
                || $tenant->isPersonal($user)
                || $tenant->isAdmin($user)
                || $module->canBeAccessedBy($user, $tenant, $module));
    }

    public function detach(User $user, Tenant $tenant, Module $module)
    {
        return $tenant->modules()
            ->where('modules.id', $module->id)
            ->whereHas(
                'moduleTenant',
                fn (Builder $query) => $query->where('module_tenant.expires_at', '>=', now()),
            )->exists()
            && $tenant->canAdmin($user);
    }

    public function attachUsers(User $user, Tenant $tenant, Module $module)
    {
        return $tenant->modules()
            ->where('modules.id', $module->id)
            ->whereHas(
                'moduleTenant',
                fn (Builder $query) => $query->where('module_tenant.expires_at', '>=', now()),
            )->exists()
            && $tenant->canAdmin($user);
    }
}
