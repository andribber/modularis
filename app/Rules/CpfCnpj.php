<?php

namespace App\Rules;

use Closure;
use geekcom\ValidatorDocs\Rules\Cnpj;
use geekcom\ValidatorDocs\Rules\Cpf;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfCnpj implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ((new Cpf())->validateCpf($attribute, $value)) {
            return;
        }

        if ((new Cnpj())->validateCnpj($attribute, $value)) {
            return;
        }

        $fail(__('validation.invalid'));
    }
}
