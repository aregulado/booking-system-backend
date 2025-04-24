<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PromoCodeFormat implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if promo code is uppercase, 6-10 characters
        if (!preg_match('/^[A-Z0-9]{6,10}$/', $value)) {
            $fail('The :attribute must be uppercase and between 6-10 characters.');
        }
    }
}
