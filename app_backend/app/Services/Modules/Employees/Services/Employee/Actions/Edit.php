<?php

namespace App\Services\Modules\Employees\Services\Employee\Actions;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Edit implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        $employeeId = $parameters['employee_id'];
        unset($parameters['employee_id']);

        $employee = $tenant->employees()->where('id', $employeeId)->first();
        $employee->update($parameters);

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
            'instructions.area' => ['sometimes', 'string'], //teams feature
            'instructions.registry' => ['sometimes', 'string'],
            'instructions.bank_account' => ['sometimes', 'array'],
            'instructions.bank_account.bank_name' => ['sometimes', 'string'],
            'instructions.bank_account.account' => ['sometimes', 'string'],
            'instructions.bank_account.bank_code' => ['sometimes', 'string'],
        ];
    }
}
