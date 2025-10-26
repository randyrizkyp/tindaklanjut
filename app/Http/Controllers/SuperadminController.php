<?php

namespace App\Http\Controllers;

use App\Models\Superadmin;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function __construct()
    {
        $superadmin = Superadmin::where('id', session('loggedSuperadmin'))->first();
        if(!$superadmin){            
            $this->logout();
        }
    }

    public function index()
    {
        return view('superadmin.beranda.index', [
            'title' => 'Beranda'
        ]);
    }

    public function logout()
    {
        if (session()->has('loggedSuperadmin')) {
            session()->pull('loggedSuperadmin');
            return redirect('/');
        }        
    }
}
