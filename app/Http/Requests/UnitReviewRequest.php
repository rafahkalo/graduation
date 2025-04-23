<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

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
        ];
    }
}
