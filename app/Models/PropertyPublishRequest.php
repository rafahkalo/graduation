<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PropertyPublishRequest extends Model
{
    use HasUuid;

    protected $fillable = [
        'user_id',
        'status',
        'admin_id',
        'reason',
        'notes',
        'property_type',
    ];

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'model');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->select(['id', 'first_name', 'last_name', 'company_name', 'phone', 'about', 'commercial_registration', 'ide']);
    }


        public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
