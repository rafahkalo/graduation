<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class FinancialTransactions extends Model
{
    use HasUuids;

    protected $fillable = [
        'status',
        'reservation_id',
        'lessor_commission_amount',
        'lessor_amount',
        'tenant_commission_amount',
        'tenant_amount',
        'platform_commission_amount',
    ];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
