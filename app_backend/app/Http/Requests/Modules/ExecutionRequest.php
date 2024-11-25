<?php

namespace App\Http\Requests\Modules;

use App\Enums\ActionEnum;
use App\Enums\ServiceEnum;
use App\Models\ModuleTenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExecutionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('access', [ModuleTenant::class, $this->route('tenant'), $this->route('module')]);
    }

    public function rules(): array
    {
        return [
            'service' => ['bail', 'string', 'required', Rule::in(ServiceEnum::values())],
            'action' => ['string', 'required', Rule::in(ActionEnum::values())],
            'instructions' => ['array', 'present'],

            ...$this->getActionValidation(),
        ];
    }

    private function getActionValidation(): array
    {
        return $this->route('module')
            ->getModuleAcessorService()
            ?->getService($this->input('service'))
            ?->getAction($this->input('action'))
            ?->getValidationRules($this->route('tenant')) ?? [];
    }
}
