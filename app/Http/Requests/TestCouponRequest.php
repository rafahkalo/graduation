<?php

namespace App\Http\Requests;

class TestCouponRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
        ];
    }
}
