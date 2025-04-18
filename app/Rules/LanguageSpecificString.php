<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LanguageSpecificString implements Rule
{
    protected string $locale;

    public function __construct()
    {
        $this->locale = app()->getLocale();
    }

    public function passes($attribute, $value)
    {
        if (! is_string($value)) {
            return false;
        }

        if ($this->locale === 'ar') {
            return preg_match('/^[\p{Arabic}\s\S]*$/u', $value) && ! preg_match('/[A-Za-z]/', $value);
        } else {
            return preg_match('/^[A-Za-z\s\S]*$/', $value) && ! preg_match('/[\p{Arabic}]/u', $value);
        }
    }

    public function message()
    {
        return 'The :attribute must contain only letters '.($this->locale === 'ar' ? 'in Arabic' : 'in English').', along with allowed symbols.';
    }
}
