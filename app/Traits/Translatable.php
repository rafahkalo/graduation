<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait Translatable
{
    public function getTranslationByLocale($locale = null)
    {
        $locale = $locale ?? request()->header('Accept-Language', App::getLocale());

        $translations = json_decode($this->translation, true);

        return $translations[$locale] ?? $translations['en'] ?? null;
    }

    public function getTranslatedAttribute()
    {
        return $this->getTranslationByLocale();
    }
}
