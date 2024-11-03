<?php

namespace App\Managers;

use App\Models\Tenant;
use App\Services\Modules\Infrastructure\ModuleProxy;
use Exception;

class ModuleManager
{
    public function __construct(private ModuleProxy $moduleProxy)
    {
    }

    public function handle(Tenant $tenant, array $parameters): void
    {
        $moduleClass = $parameters['module'];

        if (! $tenant->verifyPermissions($moduleClass)) {
            throw new Exception();
        }

        $module = $this->moduleProxy->getModule($moduleClass);
        $service = $module->getService($parameters['service']);
        $action = $service->getAction($parameters['action']);

        $module->setTenant($tenant)
            ->setService($service)
            ->setAction($action)
            ->handle($parameters['instructions']);
    }
}
