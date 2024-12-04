<?php

namespace App\Services\Modules\Finantial\Services\Finantial\Actions;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Index implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        return $tenant->finances()->get();
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [];
    }
}
