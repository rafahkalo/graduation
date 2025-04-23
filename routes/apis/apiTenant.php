<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\BusinessReviewController;
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
});
