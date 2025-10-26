<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Login;
use App\Models\Superadmin;
use App\Models\Admin;
use App\Models\Kassubag;
use App\Models\Pegawai;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Golongan;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login()
    {
        return view('login.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $role = Login::where([
            'username' => strip_tags($request->username),
        ])->first();          

        if (Auth::attempt($credentials)) {
            if($role->role=='1'){
                $request->session()->regenerate();
                $sessdata['loggedAdmin'] = 'yes';
                $request->session()->put($sessdata);
                return redirect()->intended('/admin');
            }elseif($role->role=='2'){
                $request->session()->regenerate();
                $sessdata['loggedPic'] = 'yes';
                $sessdata['user'] = $request->username;
                $sessdata['pd'] = $role->kode_pd;
                $request->session()->put($sessdata);
                return redirect()->intended('/pic');
            }
        }else{
            return back()->with('fail', 'Username atau Password salah!');
        }
        
    }
    public function signout()
    {
        Session::flush();
        Session::regenerate();
        return redirect('/');      
    }

}


