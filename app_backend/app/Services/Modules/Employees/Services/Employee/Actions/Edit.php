<?php

namespace App\Services\Modules\Employees\Services\Employee\Actions;

use App\Enums\ActionEnum;
use App\Enums\ServiceEnum;
use App\Models\ModuleServices\Employees\Employee;
use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;
use Illuminate\Validation\Rule;

class Edit implements Action
{
    public function __construct(
        private readonly Employee $employee,
    ) {
    }

    public function run(Tenant $tenant, array $parameters): mixed
    {
        $employeeId = $parameters['employee_id'];
        unset($parameters['employee_id']);

        return $this->employee
            ->where('id', $employeeId)
            ->where('tenant_id', $tenant->id)
            ->update($parameters);
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'service' => ['string', 'required', Rule::in([ServiceEnum::EMPLOYEE->value])],
            'action' => ['string', 'required', Rule::in([ActionEnum::EDIT->value])],
            'instructions' => ['array', 'required'],
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
