<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Unit;

class PriceCalculator
{
    protected $unit;
    protected $activeOffer;
    protected $couponCode;
    protected $couponDiscountAmount = 0;
    protected $offerDiscountAmount = 0;

    public function __construct(Unit $unit, ?Offer $activeOffer, ?string $couponCode)
    {
        $this->unit = $unit;
        $this->activeOffer = $activeOffer;
        $this->couponCode = $couponCode;
    }

    public function calculate(): float
    {
        $price = $this->unit->price;

        if ($this->activeOffer) {
            $priceBefore = $price;
            $price = $this->activeOffer->calculateUnitPrice($price);
            $this->offerDiscountAmount = $priceBefore - $price;
        }

        if ($this->couponCode) {
            $price = $this->applyCoupon($price);
        }

        return $price;
    }

    protected function applyCoupon(float $price): float
    {
        $coupon = Coupon::where('code', $this->couponCode)->first();

        if ($coupon && $price >= $coupon->minimum_reservation_amount) {
            if ($coupon->type === 'percent') {
                $this->couponDiscountAmount = ($price * $coupon->discount_percentage) / 100;
            } elseif ($coupon->type === 'fixed') {
                $this->couponDiscountAmount = $coupon->value;
            }

            $price -= $this->couponDiscountAmount;
        }

        return $price;
    }

    public function getCouponDiscountAmount(): float
    {
        return $this->couponDiscountAmount;
    }

    public function getOfferDiscountAmount(): float
    {
        return $this->offerDiscountAmount;
    }
}
