<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use PhpOffice\PhpWord\TemplateProcessor;
use PDF;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use App\Models\Lhp;
use App\Models\Temuan;
use App\Models\Rekomendasi;
use App\Models\Detail_rekomendasi;
use App\Models\Pd;
use App\Models\Tl;


class PicController extends Controller
{
   public function __construct()
   {                  
      if (empty(Session::get('loggedPic'))) {
			Session::flush();
         Session::regenerate();
         redirect('/signout');
		}
   }

   public function index()
   {
      // return session()->all();
      $pd = explode('|', session('pd'));
      $all_pd = Pd::all();
      $fpd = collect($all_pd)->whereIn('kode_pd', $pd)->values();  
      $lhp = Lhp::all();
      return view('pic.bpk.index', [
         'title' => 'Perangkat Daerah',
         'lhp' => $lhp,
         'fpd' => $fpd,
      ]);
   }   

   public function bpkpicpd($id)
   {
      $id_lhp = Detail_rekomendasi::where([
         'id_pd' => $id,
         ])->distinct()->pluck('id_lhp');
      $lhp = Lhp::whereIn('id',$id_lhp)->where('lhp',1)->get();
      $all_pd = Pd::all();
      $fpd = collect($all_pd)->whereIn('kode_pd', $id)->values()->first();  
      return view('pic.bpk.pd', [
         'title' => 'PIC | ' . $fpd->nama_lain,
         'lhp'   => $lhp,
         'fpd'   => $fpd,
      ]);
   }   

   public function bpkpictemuan($kode_pd, $id_lhp)
   {
      $temuan = Rekomendasi::with('temuan')
      ->where('id_lhp', $id_lhp)
      ->whereRaw("CONCAT('|', id_pd, '|') REGEXP ?", ["\\|{$kode_pd}\\|"])
      ->select('id_temuan')
      ->distinct()
      ->get();

      $lhp = Lhp::where('id',$id_lhp)->where('lhp',1)->first();
      $all_pd = Pd::all();
      $fpd = collect($all_pd)->whereIn('kode_pd', $kode_pd)->values()->first();  
      // return $fpd;
      return view('pic.bpk.temuan', [
         'title' => 'PIC | ' . $fpd->nama_lain . ' | ' . $lhp->nomor,
         'temuan'   => $temuan,
         'fpd'   => $fpd,
         'lhp' => $lhp,
      ]);
   }   

   public function bpkpicrekom($kode_pd, $id_lhp, $id_temuan)
   {
      $rekom = Detail_rekomendasi::with('rekomendasi')
      ->where([
         'id_lhp' => $id_lhp,
         'id_pd'  => $kode_pd,
         'id_temuan' => $id_temuan,
      ])
      ->select('id_rekom')
      ->distinct()
      ->get();
      $temuan = Temuan::where('id', $id_temuan)->get()->first();
      $lhp = Lhp::where('id',$id_lhp)->where('lhp',1)->first();
      $all_pd = Pd::all();
      $fpd = collect($all_pd)->whereIn('kode_pd', $kode_pd)->values()->first();  
      // return $rekom;
      return view('pic.bpk.rekom', [
         'title' => 'PIC | ' . $fpd->nama_lain . ' | ' . $lhp->nomor,
         'temuan'   => $temuan,
         'rekom'   => $rekom,
         'fpd'   => $fpd,
         'lhp' => $lhp,
      ]);
   }   

   public function bpkpicpjb($kode_pd, $id_lhp, $id_temuan,  $id_rekom)
   {
      $pjb = Detail_rekomendasi::with('pengembalian.login')
      ->where([
         'id_lhp' => $id_lhp,
         'id_pd'  => $kode_pd,
         'id_temuan' => $id_temuan,
         'id_rekom' => $id_rekom,
      ])->get();
      // return $pjb;
      // return $pjb[0]['pengembalian'];
      $rekom = Rekomendasi::findOrFail($id_rekom);
      $temuan = Temuan::where('id', $id_temuan)->get()->first();
      $lhp = Lhp::where('id',$id_lhp)->where('lhp',1)->first();
      $all_pd = Pd::all();
      $fpd = collect($all_pd)->whereIn('kode_pd', $kode_pd)->values()->first();  
      // return $rekom;
      return view('pic.bpk.pjb', [
         'title' => 'PIC | ' . $fpd->nama_lain . ' | ' . $lhp->nomor,
         'temuan'   => $temuan,
         'rekom'   => $rekom,
         'fpd'   => $fpd,
         'lhp' => $lhp,
         'pjb' => $pjb,
      ]);
   }  

   public function bpkpicinputpbj(Request $request, $id)
   {
      // return $request;
      $validated = $request->validate([
         'ket' => 'nullable|string',
         'tgl_sts' => 'nullable|date',
         'tgl_terima_sts' => 'nullable|date',
         'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      ]);
      $user = session('user');
      $folder = 'bukti_pengembalian/' . $request->judul_lhp; 

      if ($request->hasFile('bukti')) {
         // simpan file ke folder sesuai nomor LHP
         $path = $request->file('bukti')->store($folder, 'public');
         $validated['bukti'] = $path;
      }

      // simpan data
      Tl::create([
         'id_pjb' => $id,
         'id_rekom' => $request->id_rekom,
         'ket' => $validated['ket'] ?? null,
         'nilai_pengembalian' => (float) str_replace(',', '.', str_replace('.', '', preg_replace('/[^\d.,]/', '', $request->nilai_rekom))) ?? null,
         'tgl_sts' => $validated['tgl_sts'] ?? null,
         'tgl_terima_sts' => $validated['tgl_terima_sts'] ?? null,
         'bukti' => $validated['bukti'] ?? null,
         'uploaded' => $user,
         'siptl'     => $request->has('siptl') ? 1 : 0,
      ]);

      return redirect()->back()->with('success', 'Data berhasil disimpan');
   }   

   public function bpkpichapuspjb($id)
   {
      $hapus = Tl::findOrFail($id);

      // Hapus file kalau ada
      if ($hapus->bukti && Storage::disk('public')->exists($hapus->bukti)) {
         Storage::disk('public')->delete($hapus->bukti);
      }

      // Hapus data dari database
      $hapus->delete();

      return redirect()->back()->with('success', 'Data dan file berhasil dihapus');
   }
}