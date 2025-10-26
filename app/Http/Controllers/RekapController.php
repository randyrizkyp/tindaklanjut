<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Carbon\Carbon;
use App\Models\Pyb;
use App\Models\Cuti;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class RekapController extends Controller
{
   public function __construct()
   {
      if (empty(Session::get('loggedAdmin'))) {
			Session::flush();
         Session::regenerate();
         redirect('/signout');
		}
   }

   public function rekap(Request $request)
   {      
      //$rekap = Cuti::where('status', 'disetujui')->where('tahun', $tahun)->get();
      // $rekap = Cuti::where('status', 'disetujui')->get();            
      // return $request;
      // return $request;
      // if ($request->tahun && $request->jenis_cuti){
      //    $rekap = Cuti::join('users', 'cutis.nip', '=', 'users.nip')->where('status', 'disetujui')->where('tahun', $request->tahun)->where('jeniscuti', $request->jenis_cuti)->get();
      // }
      // elseif ($request->tahun) {
      //    $rekap = Cuti::join('users', 'cutis.nip', '=', 'users.nip')->where('status', 'disetujui')->where('tahun', $request->tahun)->get();
      // }elseif ($request->jenis_cuti){
      //    $rekap = Cuti::join('users', 'cutis.nip', '=', 'users.nip')->where('status', 'disetujui')->where('jeniscuti', $request->jenis_cuti)->get();
      // }else{
      //    $rekap = Cuti::join('users', 'cutis.nip', '=', 'users.nip')->where('status', 'disetujui')->get();
      // }

      $rekap = Cuti::query()
        ->when($request->tahun, function ($query, $tahun) {
            return $query->where('tahun', $tahun);
        })
        ->when($request->jenis_cuti, function ($query, $jenis_cuti) {
            return $query->where('jeniscuti', $jenis_cuti);
        })
        ->when($request->bulan, function ($query, $bulan) {
            return $query->whereMonth('tanggal', $bulan);
        })
      //   ->when($request->status, function ($query, $status) {
      //       return $query->where('status', $status);
      //   })
        ->where('status', '!=', 'draft')
        ->get();
      // return $rekap;
      $pyb = Pyb::all();

      $data = [
         'title' => 'Rekap Cuti ASN',
         'tahun' => $request->tahun,
         'jenis_cuti' => $request->jenis_cuti,
         'rekap' => $rekap,
         'bulan' => $request->bulan,
         'pyb' => $pyb
      ];
      
      if ($request->exportExcel) {
         return Excel::download(new $rekap, 'rekap.xlsx');
      }else{
         return view('admin.rekapcuti.rekap', $data);
      }            
   }

}
