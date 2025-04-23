<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasUuid;

    protected $fillable = [
        'model_type',
        'model_id',
        'user_id',
        'filename',
        'original_name',
        'mime_type',
        'size',
        'storage_path',
        'disk',
        'extension',
        'hash',
    ];
    protected $appends = ['download_url'];

    public function getDownloadUrlAttribute()
    {
        return route('files.download', $this->id);
    }
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
