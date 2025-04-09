<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\propertySection\FeatureController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::group(['middleware' => ['localization']], function () {
    Route::post('login', [AdminController::class, 'loginAsAdmin']);
});

Route::middleware(['auth:api_admin', 'localization'])->group(function () {
    // Features Routes
    Route::resource('feature', FeatureController::class);

    // Directions Routes
    Route::resource('direction', DirectionController::class);
});
