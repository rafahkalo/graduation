<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public static $translatable = ['name', 'description1'];
    protected $appends = ['translated'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
