<?php

namespace App\Http\Requests\propertySection;

use App\Http\Requests\BaseRequest;

class FeatureRequest extends BaseRequest
{
    public function rules()
    {
        return $this->isMethod('POST') ? $this->store() : $this->update();
    }

    protected function store(): array
    {
        return [
            'name' => 'required',
            'description' => 'nullable|string',
            'type' => 'required|in:safety_element,main_service,feature',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    protected function update(): array
    {
        return [
            'feature' => [
                'required',
                'exists:features,id',
            ],
            'name' => 'sometimes',
            'description' => 'nullable|string',
            'type' => 'sometimes|in:safety_element,main_service,feature',
            'status'=>'sometimes|in:active,inactive',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
