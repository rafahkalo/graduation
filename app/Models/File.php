<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

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

    public function scopePreviewable($query)
    {
        return $query->whereIn('mime_type', [
            'image/jpeg',
            'image/png',
            'image/gif',
            'application/pdf',
            'text/plain'
        ]);
    }

    // صلاحيات الوصول
    public function canBeAccessedBy(User $user): bool
    {
        return
            $this->user_id === $user->id;
    }

    // مسار الملف المحمي
    public function getStoragePath(): string
    {
        return "property_files/{$this->property_id}/{$this->filename}";
    }
}
