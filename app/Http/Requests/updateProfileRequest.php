<?php

namespace App\Http\Requests;


class updateProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes',
            'last_name' => 'sometimes',
            'company_name' => 'sometimes',
            'about' => 'sometimes',
            'commercial_registration' => 'sometimes',
            'ide' => 'sometimes',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
