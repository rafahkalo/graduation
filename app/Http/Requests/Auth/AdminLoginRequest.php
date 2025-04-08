<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

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
