<?php

namespace App\Services\Modules\Employees\Services\Employee\Actions;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Create implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        $teams = $parameters['teams'] ?? [];
        unset($parameters['employee_id'], $parameters['teams']);

        $employee = $tenant->employees()->create($parameters);

        foreach ($teams as $teamId) {
            $employee->teams()->attach($teamId);
        }

        return $employee->load('teams');
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'instructions.name' => ['required', 'string', 'max:255'],
            'instructions.email' => ['required', 'email'],
            'instructions.occupation' => ['required', 'string', 'max:255'],
            'instructions.salary' => ['required', 'decimal:2'],
            'instructions.registry' => ['required', 'string', 'unique:employees,registry'],
            'instructions.bank_account' => ['required', 'array'],
            'instructions.bank_account.bank_name' => ['required', 'string'],
            'instructions.bank_account.account' => ['required', 'string'],
            'instructions.bank_account.bank_code' => ['required', 'string'],
            'instructions.teams' => ['sometimes', 'array'],
            'instructions.teams.*.team_id' => ['sometimes', 'string', 'exists:teams,id'],
        ];
    }
}
