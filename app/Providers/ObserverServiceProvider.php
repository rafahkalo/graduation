<?php

namespace App\Providers;

use App\Models\Direction;
use App\Models\Feature;
use App\Observers\DirectionObserver;
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
        Direction::observe(DirectionObserver::class);
    }
}
