<?php

namespace App\Services;

use App\Repositories\BusinessReviewRepo;
use Illuminate\Support\Facades\Auth;

class BusinessReviewService
{
    public function __construct(private BusinessReviewRepo $businessReviewRepo)
    {
    }

    public function store(array $data)
    {
        return $this->businessReviewRepo->updateOrCreate(  [
            'user_id' => $data['user_id'],
            'tenant_id' => Auth::id(),
        ],
            [
                'rating' => $data['rating'],
                'reason' => $data['reason'],
                'user_id' => $data['user_id'],
                'tenant_id' => Auth::id(),
            ]);
    }

}
