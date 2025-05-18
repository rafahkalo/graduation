<?php

namespace App\Http\Requests;

use App\Rules\SaudiPhoneRule;

class CodeRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', new SaudiPhoneRule],
            'code' => 'required|size:4',
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
