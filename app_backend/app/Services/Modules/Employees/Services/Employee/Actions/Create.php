<?php

namespace App\Services\Modules\Employees\Services\Employee\Actions;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Create implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        return $tenant->employees()->create($parameters);
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'instructions.name' => ['required', 'string', 'max:255'],
            'instructions.email' => ['required', 'email'],
            'instructions.occupation' => ['required', 'string', 'max:255'],
            'instructions.salary' => ['required', 'decimal:2'],
            'instructions.team_id' => ['sometimes', 'string', 'exists:teams,id'], //teams feature
            'instructions.registry' => ['required', 'string', 'unique:employees,registry'],
            'instructions.bank_account' => ['required', 'array'],
            'instructions.bank_account.bank_name' => ['required', 'string'],
            'instructions.bank_account.account' => ['required', 'string'],
            'instructions.bank_account.bank_code' => ['required', 'string'],
        ];
    }
}
