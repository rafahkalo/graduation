<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasUuids;
    protected $fillable = ['imageable_id', 'imageable_type', 'path'];

    public function imageable()
    {
        return $this->morphTo();
    }
}
