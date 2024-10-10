<?php

use App\Http\Controllers\EventsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventsController::class, 'list']);
