<?php

namespace App\Services\Modules\Employees\Services\Employee\Actions;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Index implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        return $tenant->employees()->get();
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [];
    }
}
