<?php

namespace App\Http\Requests\Tenant;

use App\Enums\Tenant\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role' => ['required', Rule::in(Role::assignableRoles(true))],
        ];
    }
}
