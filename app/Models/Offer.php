<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasUuids, SoftDeletes;
    protected $fillable = [
        'name',
        'num_usage',
        'remaining_usage',
        'status',
        'type_offer',
        'value_offer',
        'from',
        'to',
        'unit_id',
        'user_id',
    ];

    public static function getActiveOfferForUnit($unitId)
    {
        return self::where('unit_id', $unitId)
            ->where('status', 'active') // العرض فعال
            ->whereDate('from', '<=', now()) // تاريخ البدء أقل من أو يساوي اليوم
            ->whereDate('to', '>=', now()) // تاريخ الانتهاء أكبر من أو يساوي اليوم
            ->where('remaining_usage', '>', 0)
            ->first();
    }

    public function calculateUnitPrice($basePrice)
    {
        // إذا كان العرض من نوع "نسبة مئوية"
        if ($this->type_offer === 'percent') {
            $discount = ($this->value_offer / 100) * $basePrice;

            return $basePrice - $discount;
        }

        // إذا كان العرض من نوع "ثابت"
        if ($this->type_offer === 'fixed') {
            return $basePrice - $this->value_offer;
        }

        // إذا لم يكن هناك عرض، نعيد السعر الأساسي
        return $basePrice;
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class)->where('status', 'accept');
    }
}
