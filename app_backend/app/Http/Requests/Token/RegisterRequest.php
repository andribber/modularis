<?php

namespace App\Http\Requests\Token;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required', 'max:128'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();

        $data['email'] = Str::lower(filter_var($data['email'], FILTER_SANITIZE_EMAIL));
        $data['password'] = Hash::make($data['password']);

        return data_get($data, $key, $default);
    }
}
