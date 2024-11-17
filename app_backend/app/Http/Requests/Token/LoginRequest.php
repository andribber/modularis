<?php

namespace App\Http\Requests\Token;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();

        $data['email'] = Str::lower(filter_var($data['email'], FILTER_SANITIZE_EMAIL));

        return data_get($data, $key, $default);
    }
}
