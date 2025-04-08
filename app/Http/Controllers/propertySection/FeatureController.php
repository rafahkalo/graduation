<?php

namespace App\Http\Controllers\propertySection;

use App\Http\Controllers\Controller;
use App\Http\Requests\propertySection\FeatureRequest;
use App\Services\propertySection\FeatureService;
use Illuminate\Http\JsonResponse;

class FeatureController extends Controller
{
    public function __construct(private FeatureService $featureService)
    {
    }

    public function index()
    {
        $status = request()->query('status') ?? null;
        $result = $this->featureService->index(per_page: request()->per_page ?? 8, status: $status);

        return $this->apiResponse(data: $result);
    }

    public function store(FeatureRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $this->featureService->store($validatedData);

        return $this->apiResponse();
    }

    public function update(FeatureRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $this->featureService->update($validatedData);

        return $this->apiResponse();
    }

    public function destroy($featureId): JsonResponse
    {
        $this->featureService->delete($featureId);

        return $this->apiResponse();
    }
}
