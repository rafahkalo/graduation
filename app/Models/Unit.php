<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Unit extends Model
{
    use HasUuids, SoftDeletes;

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
    ];
    protected $casts = [
        'translation' => 'array',
        'rating_details' => 'array',
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
        return $this->belongsTo(Category::class);
    }

  /*  public function reviews(): HasMany
    {
        return $this->hasMany(UnitReview::class, 'unit_id');
    }
  */

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
