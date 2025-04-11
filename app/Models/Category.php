<?php

namespace App\Models;

use App\Const\GlobalConst;
use App\Traits\HasUuid;
use App\Traits\Media;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuid, Translatable, Media;
    protected $fillable = [
        'name',
        'translation',
        'status',
        'description',
        'image',
    ];
    public static $translatable = ['name'];
    protected $appends = ['translated', 'image_path'];
    protected $hidden = ['translation', 'image'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($feature) {
            if ($feature->image) {
                $feature->deleteImage($feature->image);
            }
        });
    }

    public function getImagePathAttribute(): string
    {
        return GlobalConst::SERVER_PATH . '/' . 'storage' . '/' . $this->image;
    }
}
