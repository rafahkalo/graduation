<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Direction;
use App\Models\Feature;
use App\Models\Unit;
use App\Observers\CategoryObserver;
use App\Observers\DirectionObserver;
use App\Observers\FeatureObserver;
use App\Observers\UnitObserver;
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
        Category::observe(CategoryObserver::class);
        Unit::observe(UnitObserver::class);
    }
}
