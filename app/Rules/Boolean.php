<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class Boolean implements ValidationRule
{
    use ValidatesAttributes;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->validateBoolean($attribute, $value) || $value === 'true' || $value === 'false') {
            return;
        }

        $fail('validation.boolean');
    }
}
