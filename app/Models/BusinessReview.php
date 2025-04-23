<?php

namespace App\Models;

use App\Casts\DecimalCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessReview extends Model
{
    use HasUuids;

    protected $fillable = ['reason', 'rating', 'tenant_id', 'user_id'];
    protected $casts = [
        'rating' => DecimalCast::class . ':2',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
