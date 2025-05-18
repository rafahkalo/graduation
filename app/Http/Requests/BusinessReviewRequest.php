<?php

namespace App\Http\Requests;

class BusinessReviewRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|string|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'reason' => 'required|string',
        ];
    }
}
