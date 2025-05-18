<?php

namespace App\Services;

use App\Models\Reservation;
use App\Repositories\UnitReviewRepo;

class UnitReviewService
{
    public function __construct(private UnitReviewRepo $unitReviewRepositories)
    {
    }

    public function store(array $data)
    {
        $reservation = Reservation::with('unit')->findOrFail($data['reservation_id']);

        if ($reservation->tenant_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return $this->unitReviewRepositories->create($data);
    }
}
