<?php

namespace App\Http\Requests\Token;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    private const WEB_LOGIN = 'web_login';

    public function rules(): array
    {
        return [
            'expiration_date' => ['integer', 'gte:'.now()->addMinutes(30)->timestamp],
            'name' => ['nullable', 'string'],
            'refresh' => ['sometimes', 'boolean'],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $data = parent::validated();

        if (is_null($data['name'] ?? null)) {
            $data['name'] = self::WEB_LOGIN;
        }

        return data_get($data, $key, $default);
    }
}
