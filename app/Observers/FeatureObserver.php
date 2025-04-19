<?php

namespace App\Observers;

use App\Jobs\TranslateModelJob;
use App\Models\Feature;

class FeatureObserver
{
    public function created(Feature $feature): void
    {
        $columns = Feature::$translatable;
        TranslateModelJob::dispatch($feature, $columns);
    }

    public function updated(Feature $feature): void
    {
        $columns = Feature::$translatable;
        TranslateModelJob::dispatch($feature, $columns);
    }

    public function deleted(Feature $allFeature): void
    {
    }
}
