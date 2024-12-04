<?php

namespace App\Managers;

use App\Models\Module;
use App\Models\Tenant;

class ModuleManager
{
    public function handle(Tenant $tenant, Module $module, array $parameters): mixed
    {
        $moduleAcessor = $module->getModuleAcessorService();
        $service = $moduleAcessor?->getService($parameters['service'] ?? null);
        $action = $service?->getAction($parameters['action'] ?? null);

        if (is_null($service) || is_null($action)) {
            return null;
        }

        return $moduleAcessor->setTenant($tenant)
            ->setService($service)
            ->setAction($action)
            ->handle($parameters['instructions'] ?? null);
    }
}
