<?php

namespace App\Http\Requests\Modules;

use Illuminate\Foundation\Http\FormRequest;

class ExecutionRequest extends FormRequest
{
    public function rules(): array
    {
        return $this->getActionValidation();
    }

    private function getActionValidation(): array
    {
        return $this->route('module')
            ->getModuleAcessorService()
            ->getService($this->input('service'))
            ->getAction($this->input('action'))
            ->getValidationRules();
    }
}
