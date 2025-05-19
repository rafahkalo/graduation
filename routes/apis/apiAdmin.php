<?php

use App\Http\Controllers\auth\AdminController;
use App\Http\Controllers\BusinessReviewController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FinancialTransactionsController;
use App\Http\Controllers\propertySection\CategoryController;
use App\Http\Controllers\propertySection\DirectionController;
use App\Http\Controllers\propertySection\FeatureController;
use App\Http\Controllers\propertySection\PropertyController;
use App\Http\Controllers\propertySection\PropertyPublishRequestController;
use App\Http\Controllers\propertySection\UnitController;
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
    Route::get('/files/{fileId}/download', [FileController::class, 'download'])->name('files.download');

    // PropertyPublishRequest Routes
    Route::resource('property-approval-requests', PropertyPublishRequestController::class)->only(['index', 'update', 'show']);
    Route::resource('property', PropertyController::class)->only(['index', 'show']);
    Route::resource('unit', UnitController::class)->only(['index', 'show', 'update']);
    Route::post('test-coupon', [CouponController::class, 'testCoupon']);
    Route::resource('coupon', CouponController::class)->only(['index', 'show']);
    Route::get('/units-waiting', [UnitController::class, 'indexForAdmin']);
    Route::get('reviews', [BusinessReviewController::class, 'index']);
    Route::get('businessReviews', [BusinessReviewController::class, 'businessReviews']);


    Route::post('payment', [FinancialTransactionsController::class, 'payment']);
    Route::resource('financial-transaction', FinancialTransactionsController::class)->only(['index', 'update', 'show']);
});
