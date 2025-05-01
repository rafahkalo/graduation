<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasUuids, SoftDeletes;
    protected $fillable = [
        'reservation_source',
        'status',
        'from',
        'to',
        'lessor_commission',
        'lessor_commission_amount',
        'lessor_amount',
        'tenant_commission',
        'tenant_commission_amount',
        'tenant_amount',
        'coupon_id',
        'offer_id',
        'coupon_amount',
        'offer_amount',
        'platform_commission_amount',
        'user_id',
        'tenant_id',
        'unit_id',
    ];
}
