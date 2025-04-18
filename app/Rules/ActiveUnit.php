<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ActiveUnit implements Rule
{
    protected $reservation_type;

    protected $errorMessage; // متغير لحفظ رسالة الخطأ المخصصة

    /**
     * Constructor to optionally filter by type.
     *
     * @param  string|null  $reservation_type
     */
    public function __construct($reservation_type = null)
    {
        $this->reservation_type = $reservation_type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // التحقق من حالة الوحدة أولاً
        $unitQuery = DB::table('units')
            ->where('id', $value)
            ->where('status', 'active')
            ->where('accept_by_admin', 'accepted');

        if ($this->reservation_type) {
            $unitQuery->where('reservation_type', $this->reservation_type);
        }

        // إذا لم تكن الوحدة صالحة، نضبط رسالة الخطأ ونرجع false
        if (! $unitQuery->exists()) {
            $this->errorMessage = 'The selected unit is not active or does not meet the required criteria.';

            return false;
        }

        // التحقق من أن المستخدم الذي يملك هذه الوحدة لديه agree_installment = 1
        $userQuery = DB::table('units')
            ->join('users', 'units.user_id', '=', 'users.id')
            ->where('units.id', $value)
            ->where('users.agree_installment', 1);

        if (! $userQuery->exists()) {
            $this->errorMessage = 'The owner of this unit is not eligible for installment.';

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMessage ?? 'Validation failed.';
    }
}
