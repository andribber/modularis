<?php

namespace App\Services\Modules\Finantial\Services\Expense\Actions;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Create implements Action
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
