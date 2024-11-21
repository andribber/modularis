<?php

namespace App\Services\Modules\Employees\Services\Team\Actions;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Edit implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        return [];
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [];
    }
}
