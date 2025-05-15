<?php

namespace App\Http\Requests;

use App\Rules\ActiveUnit;
use App\Rules\ReservationStatusPending;

class AddReservationRequest extends BaseRequest
{
    public function rules(): array
    {
        $reservationId = $this->input('reservation_id');

        return [
            'reservation_id' => [
                'required',
                'exists:reservations,id',
                new ReservationStatusPending($reservationId),
            ],
            'unit_id' => [
                'required',
                'exists:units,id',
                new ActiveUnit,
            ],
            'from' => [
                'required',
                'date',
                'after_or_equal:today', // لا يسمح بحجز تواريخ قديمة
            ],
            'to' => [
                'required',
                'date',
                'after:from',
            ],

            // Gift-related fields
            'is_gift'          => ['nullable', 'boolean'],
            'gifted_to_email'  => ['required_if:is_gift,1', 'email'],
            'gifted_user_name'  => ['required_if:is_gift,1', 'string'],
            'gift_message'     => ['nullable', 'string', 'max:500'],
        ];
    }
}
