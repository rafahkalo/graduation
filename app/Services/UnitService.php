<?php

namespace App\Services;

use App\Models\Unit;
use App\Repositories\UnitRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UnitService
{
    public function __construct(private UnitRepo $unitRepo)
    {

    }

    public function storeUnit(array $data)
    {
        Log::info(print_r($data, true));

        if (!isset($data['unit_id'])) {
            return $this->unitRepo->create($data);
        } else {
            return $this->unitRepo->update($data, $data['unit_id']);
        }
    }

    public function index(int $per_page)
    {
        return $this->unitRepo->filterUnits($per_page);
    }

    public function show(string $id)
    {
        $filters = ['id' => $id];

        // إعداد العلاقات بناءً على نوع المستخدم
        if (Auth::guard('api_admin')->check()) {
            $with = [
                'images', 'features',
                'property.location.direction',
                'user:id,first_name,last_name,company_name,about,phone,is_verified,image,ide,commercial_registration',
            ];

            $unit = $this->unitRepo->getObject(filters: $filters, with: $with);
        } elseif (Auth::guard('api_tenant')->check()) {
            $unit = Unit::with([
                'images', 'features',
                'property.location.direction',
                'user:id,first_name,last_name,company_name,about',
            ])
                ->where('id', $id)
                ->where('status', '=', 'active')
                ->first();
        } elseif (Auth::guard('api')->check()) {
            $unit = Unit::with([
                'images', 'features',
                'property.location.direction',
                'user',
            ])
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->first();
        } else {
            $unit = Unit::with([
                'images', 'features',
                'property.location.direction',
                'user:id,first_name,last_name,company_name,about',
            ])
                ->where('id', $id)
                ->where('status', '=', 'active')
                ->first();
        }

        if (!$unit) {
            abort(404, 'Unit not found');
        }

        return $unit;
    }
}
