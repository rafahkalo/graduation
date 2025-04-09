<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DirectionRequest extends BaseRequest
{
    public function rules()
    {
        return $this->isMethod('POST') ? $this->store() : $this->update();
    }

    protected function store(): array
    {
        return [
            'name' => 'required',
        ];
    }

    protected function update(): array
    {
        return [
            'direction' => [
                'required',
                'exists:directions,id',
            ],
            'name' => 'sometimes',
            'status'=>'sometimes|in:active,inactive',
        ];
    }
}
