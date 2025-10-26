<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Cuti;


class ExcelController extends Controller
{
    public function export(Request $request)
    {
        // if($request->tahun && $request->jenis_cuti){
        //     $cuti = Cuti::where('status', 'disetujui')->where('tahun', $request->tahun)->where('jenis', $request_jenis_cuti)->get();
        // }elseif($request->tahun){
        //     $cuti = Cuti::where('status', 'disetujui')->where('tahun', $request->tahun)->get();
        // }elseif($request->jenis_cuti){
        //     $cuti = Cuti::where('status', 'disetujui')->where('jenis', $request->jenis_cuti)->get();
        // }else{
        //     $cuti = Cuti::where('status', 'disetujui')->get();
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

        // return $cuti;
        return Excel::download(new DataExport($rekap), 'laporan.xlsx');
    }
}