<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthPic
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('loggedPic') && $request->path() != '/') {
            return redirect('/')->with('fail', 'Anda Bukan Pic');
        }

        if (session()->has('loggedPic') && $request->path() == '/') {
            return redirect('/')->with('logged', 'Anda Sudah Login');
        }
        return $next($request);
    }
}