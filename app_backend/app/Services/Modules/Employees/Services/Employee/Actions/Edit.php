<?php

namespace App\Services\Modules\Employees\Services\Employee\Actions;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Edit implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        $employeeId = $parameters['employee_id'];
        $teams = $parameters['teams'] ?? [];
        unset($parameters['employee_id'], $parameters['teams']);

        $employee = $tenant->employees()->where('id', $employeeId)->first();

        if ($teams !== []) {
            $employee->teams()->sync([]);
        }

        $employee->update($parameters);

        foreach ($teams as $teamId) {
            $employee->teams()->attach($teamId);
        }

        return $employee->refresh();
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'instructions.employee_id' => ['required', 'string', 'exists:employees,id'],
            'instructions.name' => ['sometimes', 'string', 'max:255'],
            'instructions.email' => ['sometimes', 'email', 'unique:users,email'],
            'instructions.occupation' => ['sometimes', 'string', 'max:255'],
            'instructions.salary' => ['sometimes', 'string'],
            'instructions.registry' => ['sometimes', 'string'],
            'instructions.bank_account' => ['sometimes', 'array'],
            'instructions.bank_account.bank_name' => ['sometimes', 'string'],
            'instructions.bank_account.account' => ['sometimes', 'string'],
            'instructions.bank_account.bank_code' => ['sometimes', 'string'],
            'instructions.teams' => ['sometimes', 'array'],
            'instructions.teams.*.team_id' => ['sometimes', 'string', 'exists:teams,id'],
        ];
    }
}
