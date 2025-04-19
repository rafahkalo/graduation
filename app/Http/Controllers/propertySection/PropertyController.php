<?php

namespace App\Http\Controllers\propertySection;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PropertyRequest;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;

class PropertyController extends BaseController
{
    public function __construct(private PropertyService $propertyService)
    {
    }

    public function index(): JsonResponse
    {
        $result = $this->propertyService->index(request()->per_page ?? 8);

        return $this->apiResponse(data: $result);

    }

    public function store(PropertyRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->propertyService->store($data);

        return $this->apiResponse(data: $result);
    }
}
