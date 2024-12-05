<?php

namespace App\Http\Requests\Tenant;

use App\Enums\Module\ModuleRoles;
use App\Enums\Tenant\Role;
use App\Models\User;
use App\Rules\UserIsAttachedToTenant;
use App\Rules\UserIsntAttachedToTenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttachUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'members' => ['required', 'array'],
            'members.*' => ['required', 'array'],
            'members.*.user_id' => [
                'required_without:members.*.email',
                'string',
                'exists:users,id',
                new UserIsntAttachedToTenant($this->route('tenant')),
            ],
            'members.*.email' => [
                'required_without:members.*.user_id',
                'email',
                'exists:users,email',
                new UserIsntAttachedToTenant($this->route('tenant')),
            ],
            'members.*.role' => ['required', Rule::in(Role::assignableRoles(true))],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $data = parent::validated();

        foreach ($data['members'] as &$member) {
            if (! isset($member['user_id'])) {
                $member['user_id'] = User::where('email', $member['email'])->first()->id;
            }
        }

        return data_get($data, $key, $default);
    }
}
