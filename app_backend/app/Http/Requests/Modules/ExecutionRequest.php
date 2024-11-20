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
            'action' => ['string', 'required', Rule::in(ActionEnum::values())],
            'instructions' => ['array', 'required'],
            'instructions.*' => $this->getActionValidation(),
        ];
    }

    private function getActionValidation(): array
    {
        $moduleAcessor = $this->route('module')->getModulegetModuleAcessorService();
        $service = $moduleAcessor->getService($this->input('service'));
        $action = $service->getAction($this->input('action'));

        return $action->getValidationRules();
    }
}
