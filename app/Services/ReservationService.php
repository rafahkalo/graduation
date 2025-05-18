<?php

namespace App\Services;

use App\Const\Commission;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Reservation;
use App\Models\Tenant;
use App\Models\Unit;
use App\Repositories\ReservationRepo;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function __construct(
        private ReservationRepo $reservationRepo,
    private FinancialTransactionsService $financialTransactionsService)
    {
    }

    public function calculationPrice(array $data)
    {
        $response = [];
        $unit = Unit::where('id', $data['unit_id'])->first();
        $activeOffer = Offer::getActiveOfferForUnit($unit->id);
        $couponCode = $data['coupon_code'] ?? null;
        $num_person =  $data['num_person'] ?? 0;

        $response['offer_id'] = $activeOffer?->id;
        if (isset($data['coupon_code'])) {
            $response['coupon_id'] = Coupon::where('code', $data['coupon_code'])->value('id');
        }

        $priceCalculator = new PriceCalculator($unit, $activeOffer, $couponCode, $num_person);
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
        $response['num_person'] = $data['num_person'];
        $response['user_id'] = $unit->user_id;

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

    public function confirmReservation(array $data): array
    {
        $lock = Cache::lock('property_booking:' . $data['unit_id'], 10);

        if (!$lock->get()) {
            throw new Exception('try_again');
        }

        try {
            DB::transaction(function () use ($data) {
                if ($this->hasOverlappingReservations($data['unit_id'], $data['from'], $data['to'])) {
                    throw new Exception('property_unavailable');
                }

                $extra = [];

                if (isset($data['is_gift'])) {

                    $tenant = Tenant::updateOrCreate(['first_name' => $data['gifted_user_name'], 'phone' => $data['gifted_to_phone']]);
                    Tenant::updateOrCreate(
                        ['phone' => $data['gifted_to_phone']],
                        ['phone' => $data['gifted_to_phone']]
                    );

                    $extra['is_gift'] = true;
                    $extra['gifted_to_user_id'] = $tenant->id;
                    $extra['gifted_to_phone'] = $data['gifted_to_phone'];
                    $extra['gifted_user_name'] = $data['gifted_user_name'];
                    $extra['gift_message'] = $data['gift_message'];
                }

                $this->acceptReservation($data['reservation_id'], $extra);

                $this->acceptReservation($data['reservation_id']);
                $this->incrementUnitBookingCount($data['unit_id']);
                $this->financialTransactionsService->create($data['reservation_id']);

            });

            return [
                'reservation_id' => $data['reservation_id'],
                'unit_id' => $data['unit_id'],
                'status' => 'accept',
            ];
        } finally {
            $lock->release();
        }
    }

    private function hasOverlappingReservations(string $unitId, string $from, string $to): bool
    {
        return Reservation::where('unit_id', $unitId)
            ->where('status', 'accept')
            ->where(function ($query) use ($from, $to) {
                $query->whereBetween('from', [$from, $to])
                    ->orWhereBetween('to', [$from, $to])
                    ->orWhere(function ($q) use ($from, $to) {
                        $q->where('from', '<', $from)
                            ->where('to', '>', $to);
                    });
            })
            ->exists();
    }

    private function acceptReservation(string $reservationId, array $extraAttributes = []): void
    {
        $attributes = array_merge([
            'status' => 'accept',
            'updated_at' => now(),
        ], $extraAttributes);

        Reservation::where('id', $reservationId)->update($attributes);
    }

    private function incrementUnitBookingCount(string $unitId): void
    {
        Unit::where('id', $unitId)->increment('bookings_count');
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
