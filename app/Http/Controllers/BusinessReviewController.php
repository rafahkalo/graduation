<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessReviewRequest;
use App\Services\BusinessReviewService;
use Illuminate\Http\JsonResponse;

class BusinessReviewController extends BaseController
{
    public function __construct(private BusinessReviewService $businessReviewService)
    {
    }

    public function store(BusinessReviewRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $result = $this->businessReviewService->store($validatedData);

        return $this->apiResponse(data: $result);
    }

    public function businessReviews(): JsonResponse
    {
        $result = $this->businessReviewService->businessReviews (request()->per_page ?? 8);

        return $this->apiResponse(data: $result);
    }
}
