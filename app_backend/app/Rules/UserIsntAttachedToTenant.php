<?php

namespace App\Rules;

use App\Models\Tenant;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class UserIsntAttachedToTenant implements ValidationRule
{
    public function __construct(private readonly Tenant $tenant)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $field = match (true) {
            Str::contains($attribute, 'user_id') => 'users.id',
            Str::contains($attribute, 'email') => 'users.email',
        };

        if ($this->tenant->users()->where($field, $value)->exists()) {
            $fail(__('validation.exists'));
        }
    }
}
