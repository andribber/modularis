<?php

namespace App\Managers;

use App\Models\Tenant;
use App\Services\Modules\Infrastructure\ModuleProxy;
use Exception;

class ModuleManagers
{
    public function __construct(private ModuleProxy $moduleProxy)
    {
    }

    public function handle(Tenant $tenant, string $moduleClass): void
    {
        if (! $this->verifyPermissions($tenant, $moduleClass)) {
            throw new Exception();
        }

        $module = $this->moduleProxy->findModule($moduleClass);
    }

    public function verifyPermissions(Tenant $tenant, string $moduleClass): bool
    {
        return $tenant->modules()
            ->where('class', $moduleClass)
            ->accessible()
            ->exists();
    }
}
