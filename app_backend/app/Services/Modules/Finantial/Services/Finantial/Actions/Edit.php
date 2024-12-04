<?php

namespace App\Services\Modules\Finantial\Services\Finantial\Actions;

use App\Models\Tenant;
use App\Rules\UserIsAttachedToTenant;
use App\Services\Modules\Interfaces\Action;

class Edit implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        $financeId = $parameters['finance_id'];
        unset($parameters['finance_id']);

        $finance = $tenant->finances()->where('id', $financeId)->first();
        $finance->update($parameters);

        return $finance->refresh();
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'instructions.amount' => ['sometimes', 'decimal:2'],
            'instructions.description' => ['sometimes', 'string', 'max:255'],
            'instructions.finance_id' => ['required', 'string', 'exists:finances,id'],
            'instructions.user_id' => [
                'nullable',
                'string',
                'exists:users,id',
                new UserIsAttachedToTenant($tenant),
            ],
        ];
    }
}