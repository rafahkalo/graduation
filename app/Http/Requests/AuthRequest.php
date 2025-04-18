<?php

namespace App\Http\Requests;

use App\Rules\SaudiPhoneRule;

class AuthRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'phone' => ['required', new SaudiPhoneRule],
            'user_type' => 'required|in:business,tenant',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => $this->phone ? SaudiPhoneRule::formatSaudiPhone($this->phone) : $this->phone,
        ]);
    }
}
