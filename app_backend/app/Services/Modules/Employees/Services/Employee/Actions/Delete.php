<?php

namespace App\Services\Modules\Employees\Services\Employee\Actions;

use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;

class Delete implements Action
{
    public function run(Tenant $tenant, array $parameters): mixed
    {
        $employee = $tenant->employees()
            ->where('id', $parameters['employee_id'])
            ->first();

        $employee->user()->delete();
        $employee->delete();

        return [];
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'instructions.employee_id' => ['required', 'string', 'exists:employees,id'],
        ];
    }
}
