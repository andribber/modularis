<?php

namespace App\Http\Requests\Token;

use App\Models\User;
use App\Rules\CpfCnpj;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'document' => ['bail', 'required', 'string', new CpfCnpj()],
            'email' => ['required', 'string', 'email', Rule::unique(User::class)],
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $data = parent::validated();

        $data['tos_accepted_at'] = now()->format('U');
        $data['email'] = Str::lower(filter_var($data['email'], FILTER_SANITIZE_EMAIL));
        $data['password'] = Hash::make($data['password']);

        return data_get($data, $key, $default);
    }
}
