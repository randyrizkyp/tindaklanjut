<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthKassubag
{    
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('loggedKassubag') && $request->path() != '/') {
            return redirect('/')->with('fail', 'Anda Bukan Kassubag OPD');
        }

        if (session()->has('loggedKassubag') && $request->path() == '/') {
            return redirect('/')->with('logged', 'Anda Sudah Login');
        }
        return $next($request);
    }
}
