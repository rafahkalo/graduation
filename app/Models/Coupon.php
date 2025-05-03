<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasUuids, SoftDeletes;
    protected $fillable = [
        'id',
        'code',
        'type',
        'value',
        'max_uses',
        'current_uses',
        'max_uses_per_user',
        'starts_at',
        'expires_at',
        'status',
        'description',
        'minimum_reservation_amount',
        'user_id',
    ];
}
