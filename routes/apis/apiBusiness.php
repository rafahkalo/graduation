<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\propertySection\PropertyController;
use App\Http\Controllers\propertySection\PropertyPublishRequestController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::group(['middleware' => ['localization']], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('getVerificationCode', [AuthController::class, 'getVerificationCode']);
    Route::post('checkCode', [AuthController::class, 'checkCode']);
});

Route::middleware(['auth:api', 'localization'])->group(function () {
    Route::post('updateProfile', [AuthController::class, 'updateProfile']);
    Route::resource('property-approval-requests', PropertyPublishRequestController::class)->only(['store', 'update', 'index']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
});

Route::middleware(['auth:api', 'localization', 'is_verified'])->group(function () {
    Route::resource('property', PropertyController::class)->only(['store', 'update', 'index', 'show']);
});
