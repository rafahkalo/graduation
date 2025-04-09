<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectionRequest;
use App\Http\Requests\propertySection\FeatureRequest;
use App\Services\DirectionService;
use App\Services\propertySection\FeatureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DirectionController extends Controller
{
    public function __construct(private DirectionService $directionService)
    {
    }

    public function index(): JsonResponse
    {
        $status = request()->query('status') ?? null;
        $result = $this->directionService->index(per_page: request()->per_page ?? 8, status: $status);

        return $this->apiResponse(data: $result);
    }

    public function store(DirectionRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $this->directionService->store($validatedData);

        return $this->apiResponse();
    }

    public function update(DirectionRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $this->directionService->update($validatedData);

        return $this->apiResponse();
    }

    public function destroy($featureId): JsonResponse
    {
        $this->directionService->delete($featureId);

        return $this->apiResponse();
    }

}
