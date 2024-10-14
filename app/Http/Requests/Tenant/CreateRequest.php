<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $data = parent::validated();

        return data_get($data, $key, $default);
    }
}
