<?php

use App\Http\Controllers\BusinessReviewController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\propertySection\DirectionController;
use App\Http\Controllers\propertySection\PropertyController;
use App\Http\Controllers\propertySection\UnitController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['localization']], function () {
    Route::get('countries', [CountryController::class, 'index']);
    Route::resource('property', PropertyController::class)->only(['index', 'show']);
    Route::resource('direction', DirectionController::class);
    Route::resource('unit', UnitController::class)->only(['index', 'show']);
    Route::get('businessReviews', [BusinessReviewController::class, 'businessReviews']);
    Route::get('config-home', [PropertyController::class, 'configHome']);
    Route::post('calculation-price', [ReservationController::class, 'calculationPrice']);
    Route::get('getAvailableDaysForUnit', [ReservationController::class, 'getAvailableDaysForUnit']);
});
