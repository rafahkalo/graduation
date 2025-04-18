<?php

use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['localization']], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('getVerificationCode', [AuthController::class, 'getVerificationCode']);
    Route::post('checkCode', [AuthController::class, 'checkCode']);
});
