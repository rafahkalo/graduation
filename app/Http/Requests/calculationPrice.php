<?php

namespace App\Http\Requests;

use App\Rules\ActiveUnit;
use App\Rules\CouponValid;

class calculationPrice extends BaseRequest
{
    public function rules(): array
    {
        return [
            'unit_id' => [
                'required',
                'exists:units,id',
                new ActiveUnit,
            ],
            'coupon_code' => ['sometimes',new CouponValid()],
            'reservation_source' => 'required|in:app,reception',
        ];
    }
}
