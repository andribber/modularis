<?php

namespace App\Services\Modules\Finantial\Services\Finantial\Actions;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Delete implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        $tenant->finances()
            ->where('id', $parameters['finance_id'])
            ->delete();

        return [];
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'instructions.finance_id' => ['required', 'string', 'exists:finances,id'],
        ];
    }
}
