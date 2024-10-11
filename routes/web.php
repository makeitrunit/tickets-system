<?php

use App\Http\Controllers\EventsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventsController::class, 'list']);
Route::get('/events/{event}', [EventsController::class, 'show']);
Route::post('/events/{event}/purchase', [EventsController::class, 'purchase']);
Route::get('/purchase/status', [EventsController::class, 'status'])->name('purchase.status');
