<?php

namespace App\Services\Modules\Employees\Services\Team\Rules;

use App\Models\Tenant;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmployeeBelongsToTenant implements ValidationRule
{
    public function __construct(private readonly Tenant $tenant)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->tenant->employees()->where('id', $value)->exists()) {
            $fail(__('validation.exists'));
        }
    }
}
