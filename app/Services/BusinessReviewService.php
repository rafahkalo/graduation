<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\BusinessReviewRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessReviewService
{
    public function __construct(private BusinessReviewRepo $businessReviewRepo)
    {
    }

    public function index(int $per_page): \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
    {
        $with = ['tenant', 'user'];

        return $this->businessReviewRepo->index(
            per_page: $per_page,
            filters: [],
            with: $with
        );
    }

    public function store(array $data)
    {
        return $this->businessReviewRepo->updateOrCreate(
            [
            'user_id' => $data['user_id'],
            'tenant_id' => Auth::id(),
        ],
            [
                'rating' => $data['rating'],
                'reason' => $data['reason'],
                'user_id' => $data['user_id'],
                'tenant_id' => Auth::id(),
            ]
        );
    }

    public function businessReviews()
    {
        return User::select([
            'id',
            'first_name',
            'about',
            'phone',
            'company_name',
            'image',
        ])
            ->whereHas('businessReviews')
            ->withCount([
                'businessReviews',
                'businessReviews as average_rating' => function ($query) {
                    $query->select(DB::raw('ROUND(COALESCE(AVG(rating), 0), 2)'));
                },
            ])
            ->having('average_rating', '>', 0)
            ->orderByDesc('average_rating')
            ->orderByDesc('business_reviews_count')
            ->limit(10)
            ->get();
    }
}
