<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReservationRequest;
use App\Http\Requests\calculationPrice;
use App\Services\ReservationService;
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

    public function confirmReservation(AddReservationRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $result = $this->reservationService->confirmReservationService($validatedData);

            return $this->apiResponse(data: $result, message: 'booking_success', statusCode: 201);
        } catch (\Exception $e) {
            return $this->apiResponse(message: $e->getMessage(), statusCode: 400);
        }
    }

    public function getAvailableDaysForUnit(): JsonResponse
    {
        $result = $this->reservationService->getAvailableDaysForUnit(request()->unit_id, request()->from, request()->to);

        return $this->apiResponse(data: $result);
    }
}
