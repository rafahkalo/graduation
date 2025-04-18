<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasUuid, Translatable;

    protected $fillable = ['name', 'status'];

    protected $appends = ['translated'];

    protected $hidden = ['translation'];

    public static $translatable = ['name'];
}
