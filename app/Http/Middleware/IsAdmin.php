<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        //TODO: Se debe agregar otro dashboard para el cliente , ya que si uso el mismo genera un too many redirections ya que siempre entrara aqui
        return $next($request);
    }
}
