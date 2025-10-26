<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthKinerja
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('loggedKinerja') && $request->path() != '/') {
            return redirect('/')->with('fail', 'Anda Bukan Admin Bidang Penilaian Kinerja Aparatur dan Penghargaan');
        }

        if (session()->has('loggedKinerja') && $request->path() == '/') {
            return redirect('/')->with('logged', 'Anda Sudah Login');
        }
        return $next($request);
    }
}