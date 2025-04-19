<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LanguageText implements Rule
{
    protected string $language;

    public function __construct(string $language)
    {
        $this->language = $language;
    }

    public function passes($attribute, $value)
    {
        if (!is_string($value)) {
            return false;
        }

        if ($this->language === 'ar') {
            // تحقق من النصوص العربية
            return preg_match('/^[\p{Arabic}\s]+$/u', $value);
        } elseif ($this->language === 'en') {
            // تحقق من النصوص الإنجليزية
            return preg_match('/^[a-zA-Z\s]+$/', $value);
        }

        // إذا كانت اللغة غير مدعومة
        return false;
    }

    public function message()
    {
        return 'The :attribute field must contain only ' .
            ($this->language === 'ar' ? 'Arabic' : 'English') . ' characters.';
    }
}
