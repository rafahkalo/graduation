<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessReviewRequest;
use App\Services\BusinessReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
}
