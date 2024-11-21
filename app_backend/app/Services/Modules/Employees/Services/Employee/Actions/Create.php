<?php

namespace App\Services\Modules\Employees\Services\Employee\Actions;

use App\Enums\ActionEnum;
use App\Enums\ServiceEnum;
use App\Models\ModuleServices\Employees\Employee;
use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;
use Illuminate\Validation\Rule;

class Create implements Action
{
    public function __construct(
        private readonly Employee $employee,
    ) {
    }

    public function run(Tenant $tenant, array $parameters): mixed
    {
        return $this->employee->create(['tenant_id' => $tenant->id, ...$parameters]);
    }

    public function getValidationRules(Tenant $tenant): array
    {
        return [
            'service' => ['string', 'required', Rule::in([ServiceEnum::EMPLOYEE->value])],
            'action' => ['string', 'required', Rule::in([ActionEnum::CREATE->value])],
            'instructions' => ['array', 'required'],
            'instructions.name' => ['required', 'string', 'max:255'],
            'instructions.email' => ['required', 'email'],
            'instructions.occupation' => ['required', 'string', 'max:255'],
            'instructions.salary' => ['required', 'string'],
            'instructions.team_id' => ['sometimes', 'string', 'exists:teams,id'], //teams feature
            'instructions.registry' => ['required', 'string', 'unique:employees,registry'],
            'instructions.bank_account' => ['required', 'array'],
            'instructions.bank_account.bank_name' => ['required', 'string'],
            'instructions.bank_account.account' => ['required', 'string'],
            'instructions.bank_account.bank_code' => ['required', 'string'],
        ];
    }
}