<?php

namespace App\Http\Requests;

class updateProfileTenantRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'national_id' => 'nullable',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'ide' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ];
    }
}
