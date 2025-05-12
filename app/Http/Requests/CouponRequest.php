<?php

namespace App\Http\Requests;

use App\Models\Coupon;
use App\Rules\UserOwnsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\App;

class CouponRequest extends BaseRequest
{
    public function rules(): array
    {
        return $this->isMethod('POST') ? $this->store() : ($this->isMethod('DELETE') ? $this->destroy() : $this->update());
    }

    public function store(): array
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

    public function update(): array
    {
        return [
            'coupon' => [
                'required',
               'exists:coupons,id',
                new UserOwnsModel(Coupon::class)

        ],
            'type' => ['sometimes', Rule::in(['fixed', 'percent'])],
            'value' => ['sometimes', 'integer', 'min:1'],
            'max_uses' => ['sometimes', 'integer', 'min:1'],
            'max_uses_per_user' => ['sometimes', 'integer', 'min:1'],
            'starts_at' => ['sometimes', 'date'],
            'expires_at' => ['sometimes', 'date', 'after_or_equal:starts_at'],
            'description' => ['sometimes', 'string'],
            'minimum_reservation_amount' => ['sometimes', 'integer', 'min:1000'],
        ];
    }

    public function destroy(): array
    {
        return [
            'coupon' => [
                'required',
                'exists:coupons,id',
                new UserOwnsModel(Coupon::class)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'الكوبون موجود بالفعل لهذا المؤجر.',
            'expires_at.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد أو يساوي تاريخ البداية.',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $couponId = $this->route('coupon');
            $coupon = null;

            if (is_string($couponId)) {
                $coupon = Coupon::where('id', $couponId)
                    ->where('user_id', Auth::id())
                    ->first();
            }

            // حالة DELETE: تحقق من وجود الحجوزات
            if ($this->isMethod('DELETE')) {
                if ($coupon && $coupon->reservations()->exists()) {
                    $validator->errors()->add('coupon', __('coupon.delete_coupon_has_reservations'));
                }
            }

            // حالة POST أو UPDATE: تحقق من وجود الحجوزات
            if (!$this->isMethod('DELETE') && $coupon && $coupon->reservations()->exists()) {
                $validator->errors()->add('coupon', __('coupon.coupon_has_reservations'));
            }
        });
    }
}
