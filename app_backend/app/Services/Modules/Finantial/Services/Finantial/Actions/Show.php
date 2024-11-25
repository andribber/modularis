<?php

namespace App\Services\Modules\Finantial\Services\Finantial\Actions;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Show implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        return $tenant->finances()
            ->where('id', $parameters['finance_id'])
            ->first();
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'instructions.finance_id' => ['required', 'string', 'exists:finances,id'],
        ];
    }
}
