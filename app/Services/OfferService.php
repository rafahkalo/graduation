<?php

namespace App\Services;

use App\Repositories\OfferRepo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class OfferService
{
    public function __construct(private OfferRepo $offerRepo)
    {
    }

    public function index(int $per_page = 0, ?string $status = null): Collection|LengthAwarePaginator
    {
        $with = [];
        $filters = array_filter([
            'status' => $status,
        ]);

        if (Auth::guard('api')->check()) {
            $filters['user_id'] = Auth::id();
        }
        if (Auth::guard('api_admin')->check()) {
            $with = ['user'];
        }

        return $this->offerRepo->index(
            per_page: $per_page,
            filters: $filters,
            with: $with
        );
    }

    public function store(array $data)
    {
        return $this->offerRepo->create($data);
    }

    public function update(array $data)
    {
        return $this->offerRepo->update($data, $data['offer']);

    }

    public function show(string $couponId)
    {
        $with = [];
        $filters = ['id' => $couponId];
        if (Auth::guard('api')->check()) {
            $filters['user_id'] = Auth::id();
        }
        if (Auth::guard('api_admin')->check()) {
            $with = ['user'];
        }

        return $this->offerRepo->getObject(filters: $filters, with: $with);
    }

    public function destroy(array $data): void
    {
        $conditions = [
            'id' => $data['offer'],
            'user_id' => Auth::id(),
        ];

        $this->offerRepo->delete($conditions);
    }
}
