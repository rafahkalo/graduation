<?php

use App\Http\Controllers\auth\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\propertySection\CategoryController;
use App\Http\Controllers\propertySection\DirectionController;
use App\Http\Controllers\propertySection\FeatureController;
use App\Http\Controllers\propertySection\PropertyPublishRequestController;
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

    // Categories Routes
    Route::resource('category', CategoryController::class);

    Route::get('files/{fileId}/preview', [FileController::class, 'preview']);
    Route::get('/files/{fileId}/download', [FileController::class, 'download']);

    //PropertyPublishRequest Routes
    Route::resource('property-approval-requests', PropertyPublishRequestController::class)->only(['index', 'update', 'show']);
});
