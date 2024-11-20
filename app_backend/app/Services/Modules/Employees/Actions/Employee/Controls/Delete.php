<?php

namespace App\Services\Modules\Employees\Actions\Employee\Controls;

use App\Enums\ActionEnum;
use App\Enums\ServiceEnum;
use App\Models\Employee;
use App\Models\Tenant;
use App\Services\Modules\Interfaces\Action;
use Illuminate\Validation\Rule;

class Delete implements Action
{
    public function __construct(
        private readonly Employee $employee
    ) {
    }

    public function run(Tenant $tenant, array $parameters): mixed
    {
        return $this->employee
            ->where('id', $parameters['employee_id'])
            ->where('tenant_id', $tenant->id)
            ->delete();
    }

    public function getValidationRules(): array
    {
        return [
            'service' => ['string', 'required', Rule::in([ServiceEnum::EMPLOYEE->value])],
            'action' => ['string', 'required', Rule::in([ActionEnum::DELETE->value])],
            'instructions' => ['array', 'required'],
            'instructions.employee_id' => ['required', 'string', 'exists:employees,id'],
        ];
    }
}
