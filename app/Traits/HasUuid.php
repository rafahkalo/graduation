<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    protected static function bootHasUuid()
    {
        static::creating(function ($model) {
            $model->id = $model->id ?: Str::orderedUuid()->toString();
        });
    }

    public function initializeHasUuid()
    {
        $this->keyType = 'string';
        $this->incrementing = false;
    }
}
