<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSuperadmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('loggedSuperadmin') && $request->path() != '/') {
            return redirect('/')->with('fail', 'Anda Bukan Superadmin');
        }

        if (session()->has('loggedSuperadmin') && $request->path() == '/') {
            return redirect('/')->with('logged', 'Anda Sudah Login');
        }
        return $next($request);
    }
}
