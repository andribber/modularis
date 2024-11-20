<?php

namespace App\Services\Modules\Employees\Actions\Employee\Controls;

use App\Models\Employee;
use App\Models\Tenant;
use App\Models\User;
use App\Services\Modules\Interfaces\Action;

class Create implements Action
{
    public function __construct(
        private readonly User $user,
        private readonly Employee $employee
    ) {
    }

    public function run(Tenant $tenant, array $parameters): void
    {
        $this->employee->create(['tenant_id' => $tenant->id, ...$parameters]);
    }

    public function getValidationRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'occupation' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'string'],
            'area' => ['required', 'string'], //teams feature
            'registry' => ['required', 'string'],
            'bank_account' => ['required', 'array'],
            'bank_account.*.bank_name' => ['required', 'string'],
            'bank_account.*.account' => ['required', 'string'],
            'bank_account.*.bank_code' => ['required', 'string'],
        ];
    }
}
