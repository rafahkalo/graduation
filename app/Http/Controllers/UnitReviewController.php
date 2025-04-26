<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitReviewRequest;
use App\Services\UnitReviewService;
use Illuminate\Http\JsonResponse;

class UnitReviewController extends BaseController
{
    public function __construct(private UnitReviewService $unitReviewService)
    {
    }

    public function store(UnitReviewRequest $addUnitReviewRequest): JsonResponse
    {
        $validatedData = $addUnitReviewRequest->validated();
        $result = $this->unitReviewService->store($validatedData);

        return $this->apiResponse(data: $result);

    }
}
