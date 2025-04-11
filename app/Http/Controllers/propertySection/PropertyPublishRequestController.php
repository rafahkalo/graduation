<?php

namespace App\Http\Controllers\propertySection;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PropertyPublishRequestRequest;
use App\Services\PropertyPublishRequestService;
use Illuminate\Http\JsonResponse;

class PropertyPublishRequestController extends BaseController
{
    public function __construct(private PropertyPublishRequestService $publishRequestService)
    {
    }

    public function index(): JsonResponse
    {
        $status = request()->query('status') ?? null;
        $result = $this->publishRequestService->index(per_page: request()->per_page ?? 8, status: $status);

        return $this->apiResponse(data: $result);
    }

    public function store(PropertyPublishRequestRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $this->publishRequestService->store($validatedData);

        return $this->apiResponse();
    }

    public function update(PropertyPublishRequestRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $this->publishRequestService->update($validatedData);

        return $this->apiResponse();
    }

    public function show(string $id): JsonResponse
    {
        $result = $this->publishRequestService->show($id);

        return $this->apiResponse(data: $result);
    }
}
