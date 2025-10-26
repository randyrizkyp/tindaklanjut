<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthDiklat
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('loggedDiklat') && $request->path() != '/') {
            return redirect('/')->with('fail', 'Anda Bukan Admin Bidang Pengembangan Kompetensi Aparatur');
        }

        if (session()->has('loggedDiklat') && $request->path() == '/') {
            return redirect('/')->with('logged', 'Anda Sudah Login');
        }
        return $next($request);
    }
}