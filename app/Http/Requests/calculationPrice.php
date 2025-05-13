<?php

namespace App\Http\Requests;

use App\Rules\ActiveUnit;
use App\Rules\CouponValid;
use App\Rules\ValidPeopleCount;

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
            'from' => [
                'required',
                'date',
                'after_or_equal:today', // لا يسمح بحجز تواريخ قديمة
            ],
            'to' => [
                'required',
                'date',
                'after:from',
            ],
            'coupon_code' => ['sometimes', new CouponValid()],
            'reservation_source' => 'required|in:app,reception',
            'num_person' => [
                'required',
                'integer',
                'min:1',
                new ValidPeopleCount($this->unit_id),
            ],
        ];
    }
}
