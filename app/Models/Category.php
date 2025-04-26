<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\Media;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasUuid, Media, Translatable, SoftDeletes;

    protected $fillable = [
        'name',
        'translation',
        'status',
        'description',
        'image',
    ];

    public static $translatable = ['name'];

    protected $appends = ['translated'];

    protected $hidden = ['translation', 'deleted_at', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($feature) {
            if ($feature->image) {
                $feature->deleteImage($feature->image);
            }
        });
    }
}
