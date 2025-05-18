<?php

namespace App\Http\Controllers\propertySection;

use App\Http\Controllers\BaseController;
use App\Http\Requests\updateStatusRequest;
use App\Services\UnitService;
use Illuminate\Http\JsonResponse;

class UnitController extends BaseController
{
    public function __construct(private UnitService $unitService)
    {
    }

    public function index(): JsonResponse
    {
        $result = $this->unitService->index(request()->per_page ?? 8);

        return $this->apiResponse(data: $result);
    }

    public function indexForAdmin(): JsonResponse
    {
        $status = request()->query('status') ?? 'wait';
        $result = $this->unitService->index(request()->per_page ?? 8, $status);

        return $this->apiResponse(data: $result);
    }

    public function show(string $id): JsonResponse
    {
        $result = $this->unitService->show($id);

        return $this->apiResponse(data: $result);
    }

    public function update(updateStatusRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $result = $this->unitService->update($validatedData);

        return $this->apiResponse(data: $result);
    }
}
