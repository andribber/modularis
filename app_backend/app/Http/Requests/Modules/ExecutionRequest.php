<?php

namespace App\Http\Requests\Modules;

use App\Models\ModuleTenant;
use Illuminate\Foundation\Http\FormRequest;

class ExecutionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('access', [ModuleTenant::class, $this->route('tenant'), $this->route('module')]);
    }

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
            ->getValidationRules($this->route('tenant'));
    }
}
