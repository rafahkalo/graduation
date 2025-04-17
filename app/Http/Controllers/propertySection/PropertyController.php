<?php

namespace App\Http\Controllers\propertySection;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;
class PropertyController extends BaseController
{
    public function __construct(private PropertyService $propertyService)
    {
    }

    public function store(PropertyRequest $request): JsonResponse
    {
            $data = $request->validated();
            $result = $this->propertyService->storeProperty($data);

        return $this->apiResponse(data: $result);
    }
}
