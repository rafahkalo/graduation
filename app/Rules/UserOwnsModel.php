<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserOwnsModel implements Rule
{
    protected string $modelClass;
    protected string $userIdColumn;

    public function __construct(string $modelClass, string $userIdColumn = 'user_id')
    {
        $this->modelClass = $modelClass;
        $this->userIdColumn = $userIdColumn;
    }

    public function passes($attribute, $value): bool
    {
        $modelInstance = $this->modelClass::find($value);

        return $modelInstance && $modelInstance->{$this->userIdColumn} === Auth::id();
    }

    public function message(): string
    {
        return 'The selected record does not belong to the authenticated user.';
    }
}
