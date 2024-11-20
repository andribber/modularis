<?php

namespace App\Services\Modules\Interfaces;

use App\Models\Tenant;

interface Action
{
    public function run(Tenant $tenant, array $parameters): void;

    public function getValidationRules(): array;
}
