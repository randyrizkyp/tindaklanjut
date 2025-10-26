<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use PhpOffice\PhpWord\TemplateProcessor;
use PDF;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Login;
use App\Models\Temuan;
use App\Models\Rekomendasi;
use App\Models\Pd;
use App\Models\Role;


class UserController extends Controller
{
   public function __construct()
   {                  
      if (empty(Session::get('loggedAdmin'))) {
			Session::flush();
         Session::regenerate();
         redirect('/signout');
		}
   }

   public function index()
   {
      $user = Login::where('role', '!=', 1)->get();
      $all_pd = Pd::all();
      $role = Role::all();
      return view('admin.user.index', [
         'title' => 'Pengaturan user',
         'user' => $user,
         'pd' => $all_pd,
         'role' => $role,
      ]);
   }   

   public function inputuser(Request $request)
   {
      // return $request;
      $data = [
         'nama' => $request->nama,
         'username' => $request->username,
         'password' => Hash::make($request->password),
         'role' => $request->role,
         'kode_pd' => implode('|', $request->pd),
      ];
      Login::create($data);
      return back()->with('success','Tambah User Berhasil');
   }   
   public function updateuser(Request $request, $id)
   {
      // return $request;
      if($request->password){
         $data = [
         'nama' => $request->nama,
         'username' => $request->username,
         'password' => Hash::make($request->password),
         'role' => $request->role,
         'kode_pd' => implode('|', $request->pd),
         ];
      }else{
         $data = [
         'nama' => $request->nama,
         'username' => $request->username,
         'role' => $request->role,
         'kode_pd' => implode('|', $request->pd),
         ];
      }
      $user = Login::findOrFail($id);
      $user->update($data);
      return back()->with('success','Update User Berhasil');
   }   

}