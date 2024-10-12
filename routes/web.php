<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [EventsController::class, 'list']);
Route::get('/events/{event}', [EventsController::class, 'show']);
Route::post('/events/{event}/purchase', [EventsController::class, 'purchase']);
Route::get('/purchase/status', [EventsController::class, 'status'])->name('purchase.status');



Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'dashboard'], static function () {
    Route::get('/', static function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('events', App\Http\Controllers\Admin\EventsController::class)->names([

        'update' => 'events.update',

    ]);
});


require __DIR__.'/auth.php';
