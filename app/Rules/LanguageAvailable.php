<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Language;

class LanguageAvailable implements ValidationRule
{
    /**
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $available = Language::all()
            ->pluck('name')
            ->toArray();

        if (!in_array($value, $available)) {
            $fail('Language "' . $value . '" is not available.');
        }
    }
}
