<?php

namespace App\Http\Controllers;

use App\Http\Requests\calculationPrice;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
class ReservationController extends BaseController
{
    public function __construct(
        private ReservationService $reservationService,

    ) {
    }

    public function calculationPrice(calculationPrice $request): JsonResponse
    {
        $validatedData = $request->validated();
    $result = $this->reservationService->calculationPrice($validatedData);
        return $this->apiResponse(data: $result);
}
}
