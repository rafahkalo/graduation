<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasUuids, SoftDeletes, Translatable;
    protected $fillable = [
        'lng',
        'lat',
        'city',
        'street',
        'model_id',
        'model_type',
        'direction_id',
        'translation',
    ];
    public static $translatable = ['street', 'city'];
    protected $hidden = ['translation', 'created_at', 'updated_at', 'deleted_at', 'model_type', 'model_id'];
    protected $appends = ['translated'];

    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }
}
