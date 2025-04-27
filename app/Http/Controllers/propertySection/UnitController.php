<?php

namespace App\Http\Controllers\propertySection;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Services\PropertyService;
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

    public function show(string $id): JsonResponse
    {
        $result = $this->unitService->show($id);

        return $this->apiResponse(data: $result);
    }
}
