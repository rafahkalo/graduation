<?php

use App\Http\Controllers\FinancialTransactionsController;
use App\Http\Controllers\MyFatoorahController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/pay', [MyFatoorahController::class, 'index']);
Route::get('/callback', [MyFatoorahController::class, 'callback'])->name('myfatoorah.callback');
Route::get('/checkout', [MyFatoorahController::class, 'checkout']);
Route::post('/webhook', [MyFatoorahController::class, 'webhook']);





Route::middleware(['throttle:3,1'])->group(function () {
    Route::get('/payments/{payment}/confirm', [FinancialTransactionsController::class, 'confirm'])
        ->name('payments.confirm')
        ->middleware('signed.payment');
});
