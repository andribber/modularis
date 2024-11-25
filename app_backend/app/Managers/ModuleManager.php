<?php

namespace App\Managers;

use App\Models\Module;
use App\Models\Tenant;

class ModuleManager
{
    public function handle(Tenant $tenant, Module $module, array $parameters)
    {
        $moduleAcessor = $module->getModuleAcessorService();
        $service = $moduleAcessor->getService($parameters['service'] ?? null);
        $action = $service->getAction($parameters['action'] ?? null);

        return $moduleAcessor->setTenant($tenant)
            ->setService($service)
            ->setAction($action)
            ->handle($parameters['instructions'] ?? null);
    }
}
