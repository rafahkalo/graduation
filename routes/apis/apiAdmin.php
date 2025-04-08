<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::group(['middleware' => ['localization']], function () {
    Route::post('login', [AdminController::class, 'loginAsAdmin']);
});
