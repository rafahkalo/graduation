<?php

namespace App\Services;

use App\Repositories\NotificationRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationService
{
    public function __construct(private NotificationRepo $repo)
    {
    }

    public function index(int $per_page = 0, ?string $status = null): Collection|LengthAwarePaginator
    {
        if (Auth::guard('api')->check()) {
            $filters['user_id'] = Auth::id();
        }

        return $this->repo->index(
            per_page: $per_page,
            filters: $filters,
        );
    }

}
