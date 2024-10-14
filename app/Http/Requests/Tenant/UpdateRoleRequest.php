<?php

namespace App\Http\Requests\Tenant;

use App\Enums\Role;
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
