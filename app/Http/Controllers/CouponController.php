<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Http\Requests\TestCouponRequest;
use App\Services\CouponService;
use Illuminate\Http\JsonResponse;

class CouponController extends BaseController
{
    public function __construct(protected CouponService $couponService)
    {
    }

    public function index(): JsonResponse
    {
        $status = request()->query('status') ?? null;
        $result = $this->couponService->index(per_page: request()->per_page ?? 8, status: $status);

        return $this->apiResponse(data: $result);
    }

    public function store(CouponRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $result = $this->couponService->store($validatedData);

        return $this->apiResponse(data: $result);
    }

    public function testCoupon(TestCouponRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $result = $this->couponService->simulateCoupon($validatedData);
        if (!$result['valid']) {
            return $this->apiResponse(null, $result['message'], 422, file: $result['file'] ?? 'coupon');
        }

        return $this->apiResponse(
            data: [
            'discount' => $result['discount'],
            'final_price' => $result['final_price'],
        ],
            message: $result['message'],
            file: $result['file'] ?? 'coupon',
            messageParams: $result['message_params'] ?? []
        );
    }

    public function show($couponId): JsonResponse
    {
        $result = $this->couponService->show($couponId);

        return $this->apiResponse(data: $result);
    }

    public function update(CouponRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $result = $this->couponService->update($validatedData);

        return $this->apiResponse(data: $result);
    }
}
