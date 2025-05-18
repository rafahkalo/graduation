<?php

namespace App\Http\Requests;

use App\Rules\SaudiPhoneRule;
use Illuminate\Validation\Rule;

class AuthRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'phone' => array_merge(
                ['required'],
                $this->input('user_type') === 'business' ? [new SaudiPhoneRule] : []
            ),
            'user_type' => ['required', Rule::in(['business', 'tenant'])],
        ];
    }

    protected function prepareForValidation(): void
    {
        // ننسق الرقم فقط إذا كان نوع المستخدم business
        if ($this->input('user_type') === 'business' && $this->phone) {
            $this->merge([
                'phone' => SaudiPhoneRule::formatSaudiPhone($this->phone),
            ]);
        }
    }
}
