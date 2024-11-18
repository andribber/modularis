<?php

namespace App\Policies;

use App\Models\Module;
use App\Models\Tenant;
use App\Models\User;

class ModuleTenantPolicy
{
    public function access(User $user, Tenant $tenant, Module $module)
    {
        return $tenant->modules()->where('id', $module->id)->acessible()->exists()
            && $tenant->canAccess($user)
            && $module->canBeAccessedBy($user, $tenant);
    }

    public function attach(User $user, Tenant $tenant)
    {
        return $tenant->canAdmin($user);
    }

    public function detach(User $user, Tenant $tenant, Module $module)
    {
        return $tenant->modules()->where('id', $module->id)->acessible()->exists()
            && $tenant->canAdmin($user);
    }

    public function attachUsers(User $user, Tenant $tenant, Module $module)
    {
        return $tenant->modules()->where('id', $module->id)->acessible()->exists()
            && $tenant->canAdmin($user)
            && $module->canBeAccessedBy($user, $tenant);
    }
}
