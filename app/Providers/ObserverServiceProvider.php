<?php

namespace App\Providers;

use App\Models\Feature;
use App\Observers\FeatureObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Feature::observe(FeatureObserver::class);
    }
}
