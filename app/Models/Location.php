<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasUuids, SoftDeletes;

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
}
