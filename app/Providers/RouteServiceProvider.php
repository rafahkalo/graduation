<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
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
        Route::prefix('api/admin')
            ->group(base_path('routes/apis/apiAdmin.php'));

        Route::prefix('api/business')
            ->group(base_path('routes/apis/apiBusiness.php'));

        Route::prefix('api/tenant')
            ->group(base_path('routes/apis/apiTenant.php'));
    }
}
