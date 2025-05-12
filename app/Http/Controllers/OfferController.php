<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Services\OfferService;
use Illuminate\Http\JsonResponse;

class OfferController extends BaseController
{
    public function __construct(protected OfferService $offerService)
    {
    }

    public function index(): JsonResponse
    {
        $status = request()->query('status') ?? null;
        $result = $this->offerService->index(per_page: request()->per_page ?? 8, status: $status);

        return $this->apiResponse(data: $result);
    }

    public function show($offerId): JsonResponse
    {
        $result = $this->offerService->show($offerId);

        return $this->apiResponse(data: $result);
    }

    public function store(OfferRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $result = $this->offerService->store($validatedData);

        return $this->apiResponse(data: $result);
    }

    public function update(OfferRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $result = $this->offerService->update($validatedData);

        return $this->apiResponse(data: $result);
    }

        public function destroy(OfferRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $this->offerService->destroy($validatedData);

        return $this->apiResponse();
    }
}
