<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('loggedUser') && $request->path() != '/') {
            return redirect('/')->with('fail', 'Anda Telah Log Out');
        }

        if (session()->has('loggedUser') && $request->path() == '/') {
            return redirect('/')->with('logged', 'Anda Sudah Login');
        }
        return $next($request);
    }
}
