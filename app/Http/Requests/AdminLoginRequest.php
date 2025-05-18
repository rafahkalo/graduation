<?php

namespace App\Http\Requests;

class AdminLoginRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8|max:32',
        ];
    }
}
