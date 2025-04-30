<?php

namespace App\Repositories;

use App\Models\Reservation;

class ReservationRepo extends CoreRepository
{

    public function __construct(Reservation $reservation)
    {
        parent::__construct($reservation);
    }
}
