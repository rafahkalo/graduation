<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SaudiPhoneRule implements Rule
{
    /**
     * تحقق من صحة الرقم السعودي.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        // إزالة "+" من البداية إذا كانت موجودة
        $value = ltrim($value, '+');

        // تحقق من الرقم إذا كان يبدأ بـ 966 أو 05
        return preg_match('/^(9665|5|05)\d{8}$/', $value);
    }

    /**
     * رسالة الخطأ التي ستُعرض إذا لم يتحقق الشرط.
     */
    public function message(): string
    {
        return __('validation.saudi_phone_invalid');
    }

    /**
     * تنسيق الرقم السعودي ليصبح بصيغة دولية.
     */
    public static function formatSaudiPhone(string $phone): ?string
    {
        // إزالة "+" من البداية إذا كانت موجودة
        $phone = ltrim($phone, '+');

        // إذا كان الرقم يبدأ بـ 05، قم بإزالة الصفر
        if (str_starts_with($phone, '05')) {
            $phone = substr($phone, 1); // إزالة أول حرف (الصفر)
        }

        // إذا كان الرقم يبدأ بـ 5، أضف 966
        if (str_starts_with($phone, '5')) {
            $phone = '966' . $phone;
        }

        // تحقق من صحة الرقم
        if (preg_match('/^9665\d{8}$/', $phone)) {
            return $phone;
        }

        return null; // إرجاع null إذا لم يكن الرقم صحيحًا
    }
}
