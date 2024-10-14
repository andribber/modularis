<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class PrefixedUlid implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = Str::of($value);

        if (! $value->contains('_')) {
            $fail(__('validation.prefixed-ulid'));

            return;
        }

        [$prefix, $ulid] = $value->explode('_');

        if (Str::length($prefix) > 5 || ! Str::isUlid($ulid)) {
            $fail(__('validation.prefixed-ulid'));
        }
    }
}
