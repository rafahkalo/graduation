<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\propertySection\PropertyPublishRequestController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::group(['middleware' => ['localization']], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('getVerificationCode', [AuthController::class, 'getVerificationCode']);
    Route::post('checkCode', [AuthController::class, 'checkCode']);

});

Route::middleware(['auth:api', 'localization'])->group(function () {
   Route::resource('property-approval-requests', PropertyPublishRequestController::class)->only(['store', 'update', 'index']);
});
