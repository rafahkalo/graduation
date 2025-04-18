<?php

namespace App\Http\Requests;

class CategoryRequest extends BaseRequest
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
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    protected function update(): array
    {
        return [
            'category' => [
                'required',
                'exists:categories,id',
            ],
            'name' => 'sometimes',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:active,inactive',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
