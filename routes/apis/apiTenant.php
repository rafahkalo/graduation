<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\BusinessReviewController;
use App\Http\Controllers\propertySection\PropertyController;
use App\Http\Controllers\propertySection\UnitController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UnitReviewController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['localization']], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('getVerificationCode', [AuthController::class, 'getVerificationCode']);
    Route::post('checkCode', [AuthController::class, 'checkCode']);
});

Route::middleware(['auth:api_tenant', 'localization'])->group(function () {
    Route::post('updateProfile', [AuthController::class, 'updateProfileAsTenant']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('business-review', [BusinessReviewController::class, 'store']);
    Route::post('unit-review', [UnitReviewController::class, 'store']);
    Route::get('config-home', [PropertyController::class, 'configHome']);
    Route::get('businessReviews', [BusinessReviewController::class, 'businessReviews']);
    Route::resource('unit', UnitController::class)->only(['index', 'show']);
    Route::post('calculation-price', [ReservationController::class, 'calculationPrice']);
    Route::resource('property', PropertyController::class)->only(['index', 'show']);
});
