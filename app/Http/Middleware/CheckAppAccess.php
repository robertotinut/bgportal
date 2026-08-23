<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAppAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $appCode): Response
    {
        if (!Auth::check() || !Auth::user()->canAccessApp($appCode)) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki hak akses ke modul aplikasi tersebut. Silakan hubungi Administrator.');
        }

        return $next($request);
    }
}
