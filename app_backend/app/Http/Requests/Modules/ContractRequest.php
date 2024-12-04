<?php

namespace App\Http\Requests\Modules;

use App\Enums\Module\Name;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContractRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'required', Rule::in(Name::values())],
        ];
    }

    public function validated($key = null, $default = null): mixed
    {
        $data = parent::validated();

        return data_get($data, $key, $default);
    }
}
