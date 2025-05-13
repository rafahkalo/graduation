<?php

namespace App\Services;

use App\Const\Commission;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Reservation;
use App\Models\Unit;
use App\Repositories\ReservationRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
        if (isset($data['coupon_code'])) {
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

        $response['reservation_source'] = $data['reservation_source'];

        if (Auth::guard('api_tenant')->check()) {
            $response['tenant_id'] = Auth::id();
            $response['from'] = $data['from'];
            $response['to'] = $data['to'];
            $response['unit_id'] = $data['unit_id'];

            return $this->reservationRepo->create($response);
        } else {
            return $response;
        }
    }

    public function confirmReservationService(array $data): array
    {
        $lock = Cache::lock('property_booking:' . $data['unit_id'], 10);

        if (!$lock->get()) {
            throw new \Exception('try_again');
        }

        try {
            DB::transaction(function () use ($data) {
                // تحقق من وجود حجوزات متداخلة
                $overlapping = Reservation::where('unit_id', $data['unit_id'])
                    ->where('status', 'accept')
                    ->where(function ($query) use ($data) {
                        $query->whereBetween('from', [$data['from'], $data['to']])
                            ->orWhereBetween('to', [$data['from'], $data['to']])
                            ->orWhere(function ($q) use ($data) {
                                $q->where('from', '<', $data['from'])
                                    ->where('to', '>', $data['to']);
                            });
                    })
                    ->exists();

                if ($overlapping) {
                    throw new \Exception('property_unavailable');
                }

                // تحديث حالة الحجز
                Reservation::query()->where('id', $data['reservation_id'])->update([
                    'status' => 'accept',
                    'updated_at' => now(),
                ]);

                // تحديث العداد
                Unit::where('id', $data['unit_id'])->increment('bookings_count');
            });

            // نرجع بيانات بسيطة فقط
            return [
                'reservation_id' => $data['reservation_id'],
                'unit_id' => $data['unit_id'],
                'status' => 'accept',
            ];

        } finally {
            $lock->release();
        }
    }

    public function getAvailableDaysForUnit($unitId, $from, $to): array
    {
        $startDate = Carbon::parse($from)->startOfDay();
        $endDate = Carbon::parse($to)->endOfDay();

        // جلب الحجوزات الخاصة بهذه الوحدة ضمن الفترة
        $reservations = Reservation::where('unit_id', $unitId)
            ->where('status', 'accept')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('from', [$startDate, $endDate])
                    ->orWhereBetween('to', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('from', '<', $startDate)
                            ->where('to', '>', $endDate);
                    });
            })
            ->get(['from', 'to']);

        // توليد جميع الأيام في الفترة
        $allDays = collect();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $allDays->push($date->toDateString());
        }

        // جمع الأيام المحجوزة
        $bookedDays = collect();
        foreach ($reservations as $reservation) {
            $from = Carbon::parse($reservation->from);
            $to = Carbon::parse($reservation->to);

            for ($date = $from; $date->lte($to); $date->addDay()) {
                $bookedDays->push($date->toDateString());
            }
        }

        // طرح الأيام المحجوزة من الكل
        $availableDays = $allDays->diff($bookedDays->unique())->values();

        return $availableDays->all(); // ترجع مصفوفة من الأيام المتاحة
    }
}
