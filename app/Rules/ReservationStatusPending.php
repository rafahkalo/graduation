<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ReservationStatusPending implements Rule
{
    protected $reservationId;

    protected $errorMessage; // تخزين رسالة الخطأ

    public function __construct($reservationId)
    {
        $this->reservationId = $reservationId;
    }

    public function passes($attribute, $value)
    {
        // جلب معلومات الحجز
        $reservation = DB::table('reservations')
            ->where('id', $this->reservationId)
            ->first(['status', 'created_at']);

        // التحقق من وجود الحجز
        if (!$reservation) {
            $this->errorMessage = 'The reservation does not exist.';

            return false;
        }

        // التحقق من وقت الإنشاء (آخر 5 دقائق)
        $createdAt = Carbon::parse($reservation->created_at);
        if ($createdAt->diffInMinutes(Carbon::now()) > 5) {
            $this->errorMessage = 'The reservation must be created within the last 5 minutes. Please create a new reservation.';

            return false;
        }

        // التحقق من حالة الحجز
        if ($reservation->status !== 'pending') {
            $this->errorMessage = 'The reservation status must be "pending".';

            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}
