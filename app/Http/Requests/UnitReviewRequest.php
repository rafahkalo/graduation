<?php

namespace App\Http\Requests;

class UnitReviewRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'unit_id' => 'required|exists:units,id',
            'cleanliness' => 'required|numeric|between:1,5',
            'accuracy' => 'required|numeric|between:1,5',
            'check_in' => 'required|numeric|between:1,5',
            'communication' => 'required|numeric|between:1,5',
            'value' => 'required|numeric|between:1,5',
            'reason' => 'nullable|string',
            'reservation_id' => 'required|exists:reservations,id',
        ];
    }
}
