<?php

namespace App\Services;

use App\Const\Commission;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Unit;
use App\Repositories\ReservationRepo;
use Illuminate\Support\Facades\Auth;

class ReservationService
{

    public function __construct(private ReservationRepo $reservationRepo)
    {
    }

    public function calculationPrice(array $data)
    {
        $response = [];
        $unit = Unit::where('id', $data['unit_id'])->first();
        $activeOffer = Offer::getActiveOfferForUnit($unit->id);
        $couponCode = $data['coupon_code'] ?? null;

        $response['offer_id'] = $activeOffer?->id;
        if(isset($data['coupon_code'])) {
            $response['coupon_id'] = Coupon::where('code', $data['coupon_code'])->value('id');
        }

        $priceCalculator = new PriceCalculator($unit, $activeOffer, $couponCode);
        //السعر النهائي مطبق عليه العرض او الكوبون
        $finalPrice = $priceCalculator->calculate();
        //عمولة المنصة من المؤجر
        $response['lessor_commission'] = Commission::commission_maskani_lessor;
        $response['lessor_commission_amount'] = $finalPrice * $response['lessor_commission'];
        $response['lessor_amount'] = $finalPrice - $response['lessor_commission_amount'];
        $response['coupon_amount'] = $priceCalculator->getCouponDiscountAmount();
        $response['offer_amount'] = $priceCalculator->getOfferDiscountAmount();

        //عمولة المنصة على المستأجر
        $response['tenant_commission'] = Commission::commission_maskani_tenant;
        $response['tenant_commission_amount'] = $finalPrice * $response['tenant_commission'];
        $response['tenant_amount'] = $finalPrice + $response['tenant_commission_amount'];
        $response['platform_commission_amount'] = $response['tenant_commission_amount'] + $response['lessor_commission_amount'];
        $response['tenant_id'] = Auth::id();
        $response['reservation_source'] = $data['reservation_source'];

        return $this->reservationRepo->create($response);
    }
}
