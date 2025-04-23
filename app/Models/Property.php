<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
class Property extends Model
{
    use HasUuids, SoftDeletes, Translatable;

    protected $fillable = [
        'id',
        'name',
        'description1',
        'user_id',
        'translation',
    ];
    protected $hidden = ['translation'];
    public static $translatable = ['name', 'description1'];
    protected $appends = ['translated'];

    public function location(): MorphOne
    {
        return $this->morphOne(Location::class, 'model');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function scopeHasFeatureInUnit(Builder $query, $featureId): Builder
    {
        return $query->whereHas('units.features', function ($q) use ($featureId) {
            $q->where('feature_id', $featureId);
        });
    }

    public function scopeHasCategoryInUnit(Builder $query, $categoryId): Builder
    {
        return $query->whereHas('units', function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        });
    }
}
