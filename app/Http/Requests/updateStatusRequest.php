<?php

namespace App\Http\Requests;

class updateStatusRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'unit' => 'required|exists:units,id',
            'accept_by_admin' => ['required', 'in:refused,accepted'],
            'message_of_admin' => 'sometimes',
        ];
    }
}
