<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CouponRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('coupons')->where(function ($query) {
                    return $query->where('user_id', $this->user_id);
                }),
            ],
            'type' => ['required', Rule::in(['fixed', 'percent'])],
            'value' => ['required', 'integer', 'min:1'],
            'max_uses' => ['nullable', 'integer', 'min:1'],
            'max_uses_per_user' => ['nullable', 'integer', 'min:1'],
            'starts_at' => ['required', 'date'],
            'expires_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'description' => ['nullable', 'string'],
            'minimum_reservation_amount' => ['required', 'integer', 'min:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'الكوبون موجود بالفعل لهذا المؤجر.',
            'expires_at.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد أو يساوي تاريخ البداية.',
        ];
    }
}
