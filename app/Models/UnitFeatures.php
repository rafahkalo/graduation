<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UnitFeatures extends Model
{
    use HasUuids;
    protected $fillable = ['unit_id', 'feature_id'];
}
