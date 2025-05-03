<?php

namespace App\Services;

use App\Models\Coupon;
use App\Repositories\CouponRepo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CouponService
{
    public function __construct(private CouponRepo $couponRepo)
    {
    }

    public function index(int $per_page = 0, ?string $status = null): Collection|LengthAwarePaginator
    {
        return $this->couponRepo->index(
            per_page: $per_page,
            filters: array_filter([
                'status' => $status,
            ])
        );
    }

    public function store(array $data)
    {
        return $this->couponRepo->create($data);
    }

    public function simulateCoupon(array $data): array
    {
        $coupon = Coupon::where('code', $data['code'])->first();
        $fakePrice = $coupon->minimum_reservation_amount ?? 1000;

        if (!$coupon) {
            return ['valid' => false, 'message' => __('not_found')];
        }

        if (now()->lt($coupon->starts_at) || now()->gt($coupon->expires_at)) {
            return ['valid' => false, 'message' => 'expired_or_not_started'];
        }

        if (!is_null($coupon->max_uses) && $coupon->current_uses >= $coupon->max_uses) {
            return ['valid' => false, 'message' => __('max_usage_reached')];
        }

        if ($coupon->type === 'percent') {
            $discount = $fakePrice * ($coupon->value / 100);
        } elseif ($coupon->type === 'fixed') {
            $discount = min($fakePrice, $coupon->value);
        } else {
            return ['valid' => false, 'message' => __('unknown_type')];
        }

        $finalPrice = $fakePrice - $discount;

        return [
            'valid' => true,
            'discount' => $discount,
            'final_price' => $finalPrice,
            'message' => 'success_coupon',
            'message_params' => [
                'discount' => number_format($discount, 2),
                'price' => number_format($fakePrice, 2),
                'final' => number_format($finalPrice, 2),
            ],
            'file' => 'coupon',
        ];
    }
}
