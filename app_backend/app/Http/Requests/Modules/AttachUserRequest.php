<?php

namespace App\Http\Requests\Modules;

use App\Enums\Module\ModuleRoles;
use App\Models\User;
use App\Rules\UserIsAttachedToTenant;
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
                new UserIsAttachedToTenant($this->route('tenant')),
            ],
            'members.*.email' => [
                'required_without:members.*.user_id',
                'email',
                'exists:users,email',
                new UserIsAttachedToTenant($this->route('tenant')),
            ],
            'members.*.role' => ['required', Rule::in(ModuleRoles::values())],
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
