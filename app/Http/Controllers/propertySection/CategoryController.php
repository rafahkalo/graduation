<?php

namespace App\Http\Controllers\propertySection;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends BaseController
{
    public function __construct(private CategoryService $categoryService) {}

    public function index()
    {
        $status = request()->query('status') ?? null;
        $result = $this->categoryService->index(per_page: request()->per_page ?? 8, status: $status);

        return $this->apiResponse(data: $result);
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $this->categoryService->store($validatedData);

        return $this->apiResponse();
    }

    public function update(CategoryRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $this->categoryService->update($validatedData);

        return $this->apiResponse();
    }

    public function destroy($categoryId): JsonResponse
    {
        $this->categoryService->delete($categoryId);

        return $this->apiResponse();
    }
}
