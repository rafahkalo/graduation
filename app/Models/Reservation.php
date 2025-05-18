<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasUuids, SoftDeletes;
    protected $fillable = [
        'reservation_source',
        'status',
        'from',
        'to',
        'num_person',
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
        'is_gift',
        'gifted_to_user_id',
        'gifted_user_name',
        'gifted_to_phone',
        'gift_message'
    ];
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class)->select(['id', 'first_name', 'last_name', 'gender', 'phone', 'ide', 'image']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->select(['id','first_name','last_name','company_name','phone',
            'about', 'image']);
    }
}
