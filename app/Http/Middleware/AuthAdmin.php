<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('loggedAdmin') && $request->path() != '/') {
            return redirect('/')->with('fail', 'Anda Bukan Admin');
        }

        if (session()->has('loggedAdmin') && $request->path() == '/') {
            return redirect('/')->with('logged', 'Anda Sudah Login');
        }
        return $next($request);
    }
}