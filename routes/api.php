<?php

use App\Http\Api\PurchaseController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api'], function () {
    Route::get('/purchase/status/{purchaseId}', [PurchaseController::class, 'status'])->name('api.purchase.status');
});

