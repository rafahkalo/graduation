<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\propertySection\PropertyController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['localization']], function () {
    Route::get('countries', [CountryController::class, 'index']);
    Route::resource('property', PropertyController::class)->only(['index']);
});
