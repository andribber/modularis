<?php

namespace App\Services\Modules\Finantial\Actions\Expense\Controls;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Create implements Action
{
    public function run(Tenant $tenant, array $parameters): void
    {
    }

    public function getValidationRules(): array
    {
        return [];
    }
}
