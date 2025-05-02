<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Unit extends Model
{
    use HasUuids, Translatable, SoftDeletes;

    protected $casts = [
        'rating_details' => 'array',
    ];
    protected $appends = ['translated', 'has_active_offer'];

    protected $hidden = ['translation'];

    public static $translatable = ['title', 'description2'];

    protected $fillable = [
        'id',
        'title',
        'description2',
        'main_image',
        'street_width',
        'space',
        'equipment',
        'property_type',
        'floor',
        'property_age',
        'status',
        'reservation_type',
        'deposit',
        'reservation_status',
        'accept_by_admin',
        'message_of_admin',
        'house_rules',
        'views',
        'price',
        'property_id',
        'user_id',
        'category_id',
        'rating_details',
        'translation',
        'guard_name',
        'guard_phone',
        'bookings_count',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($unit) {
            $unit->rating_details = [
                'cleanliness' => 0,
                'accuracy' => 0,
                'check_in' => 0,
                'communication' => 0,
                'value' => 0,
                'overall_rating_1' => 0,
                'overall_rating_2' => 0,
                'overall_rating_3' => 0,
                'overall_rating_4' => 0,
                'overall_rating_5' => 0,
                'total_reviewers' => 0,
                'current_overall_rating' => 0,
                'current_badge_code' => 0,
            ];
        });
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'unit_features');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    /*  public function reviews(): HasMany
      {
          return $this->hasMany(UnitReview::class, 'unit_id');
      }
    */

    public function scopeHasFeatureInUnit(Builder $query, $featureId): Builder
    {
        return $query->whereHas('features', function ($q) use ($featureId) {
            $q->where('feature_id', $featureId);
        });
    }

    public function scopeHasCategoryInUnit(Builder $query, $categoryId): Builder
    {
        return $query->whereHas('category', function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        });
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function hasActiveOffer(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->offers()
                ->whereDate('from', '<=', now())
                ->whereDate('to', '>=', now())
                ->exists()
        );
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
