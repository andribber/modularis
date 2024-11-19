<?php

namespace App\Http\Requests\Modules;

use App\Enums\ActionEnum;
use App\Enums\ServiceEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExecutionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'service' => ['string', 'required', Rule::in(ServiceEnum::values())],
            'action'  => ['string', 'required', Rule::in(ActionEnum::values())],
            'instructions' => ['array', 'required'],
        ];
    }
}
