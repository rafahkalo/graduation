<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::group(['middleware' => ['localization']], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('getVerificationCode', [AuthController::class, 'getVerificationCode']);
    Route::post('checkCode', [AuthController::class, 'checkCode']);

});

Route::middleware(['auth:api', 'localization'])->group(function () {

});
