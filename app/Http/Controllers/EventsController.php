<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class EventsController extends Controller
{
    public function list(): View
    {
        return view('list');
    }
}
