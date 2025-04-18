<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasUuids, SoftDeletes;

    protected $casts = [
        'rating_details' => 'array',
    ];

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

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
