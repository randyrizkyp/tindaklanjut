<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMutasi
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('loggedMutasi') && $request->path() != '/') {
            return redirect('/')->with('fail', 'Anda Bukan Admin Bidang Mutasi dan Promosi');
        }

        if (session()->has('loggedMutasi') && $request->path() == '/') {
            return redirect('/')->with('logged', 'Anda Sudah Login');
        }
        return $next($request);
    }
}