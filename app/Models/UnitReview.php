<?php

namespace App\Models;

use App\Casts\DecimalCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitReview extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'unit_id',
        'tenant_id',
        'reason',
        'rating',
        'cleanliness',
        'accuracy',
        'check_in',
        'communication',
        'value',
    ];

    protected $hidden = [
        'updated_at',
    ];
    protected $casts = [
        'rating' =>  DecimalCast::class . ':2',
        'cleanliness' => DecimalCast::class . ':2',
        'accuracy' => DecimalCast::class . ':2',
        'check_in' => DecimalCast::class . ':2',
        'communication' => DecimalCast::class . ':2',
        'value' => DecimalCast::class . ':2',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class)
            ->select('id', 'title');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class)
            ->select('id', 'user_name', 'company_name', 'image');
    }
}
