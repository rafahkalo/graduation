<?php

namespace App\Services;

use App\Models\Reservation;
use App\Repositories\FinancialTransactionsRepo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class FinancialTransactionsService
{

    public function __construct(private FinancialTransactionsRepo $repo)
    {
    }

    public function index(int $per_page = 0, ?string $status = null): Collection|LengthAwarePaginator
    {
        $filters = array_filter([
            'status' => $status,
        ]);

        $with = ['reservation.user', 'reservation.tenant'];

        return $this->repo->index(
            per_page: $per_page,
            filters: $filters,
            with: $with
        );
    }

    public function create(string $reservationId)
    {
         $data = [];
        $reservation = Reservation::find($reservationId);
        $data['reservation_id'] = $reservationId;
        $data['lessor_commission_amount'] = $reservation->lessor_commission_amount;
        $data['lessor_amount'] = $reservation->lessor_amount;
        $data['tenant_commission_amount'] = $reservation->tenant_commission_amount;
        $data['tenant_amount'] = $reservation->lessor_commission_amount;
        $data['platform_commission_amount'] = $reservation->lessor_commission_amount;

        $this->repo->create($data);
    }
}
