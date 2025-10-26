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


class BpkadminController extends Controller
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
      $lhp = Lhp::all();
      return view('admin.bpk.index', [
         'title' => 'BPK-RI',
         'lhp' => $lhp
      ]);
   }   

   public function inputlhp(Request $request)
   {
      $data = [
         'nomor' => $request->nomorlhp,
         'judul' => $request->judullhp,
         'tanggal' => $request->tanggallhp,
         'alias' => $request->aliaslhp,
         'lhp' => 1,
      ];
      Lhp::create($data);

      return back()->with('success','Input LHP Berhasil');
   }   

   public function detailbpk($id)
   {
      $lhp = Lhp::findOrFail($id);
      // $temuan = Temuan::where('id_lhp', $lhp->id)->get();
      $temuan = Temuan::withCount([
         'rekomendasi', // hitung semua rekomendasi
         'rekomendasi as rekomendasi_selesai_count' => function ($query) {
            $query->where('status', 2); // hitung hanya yang status = 2
         }
      ])
      ->where('id_lhp', $lhp->id)
      ->get();
      $rekomendasi = Rekomendasi::where('id_lhp', $lhp->id)->get();
      return view('admin.bpk.temuan', [
         'title' => 'BPK-RI | ' . $lhp->nomor . ' | Temuan',
         'lhp' => $lhp,
         'temuan' => $temuan,
         'rekomendasi' => $rekomendasi,
      ]);
   }   

   public function rekomendasibpk($id)
   {
      $temuan = Temuan::where('id', $id)->get();
      $lhp = Lhp::findOrFail($temuan[0]->id_lhp);
      $rekomendasi = Rekomendasi::where('id_temuan', $id)->get();
      $pd = Pd::all()->values();
      // return $pd;
      return view('admin.bpk.rekomendasi', [
         'title' => 'BPK-RI | ' . $lhp->nomor . ' | Rekomendasi',
         'lhp' => $lhp,
         'temuan' => $temuan,
         'rekomendasi' => $rekomendasi,
         'pd' => $pd,
      ]);
   }   

   public function inputtemuan(Request $request)
   {
      $data = [
         'id_lhp' => $request->id_lhp,
         'temuan' => $request->temuan,
      ];
      Temuan::create($data);

      return back()->with('success','Input Temuan Berhasil');
   }   
   public function edittemuan(Request $request)
   {
      $data = [
         'temuan' => $request->temuan,
      ];
      $temuan = Temuan::findOrFail($request->id_temuan);
      $temuan->update($data);

      return back()->with('success','Update Temuan Berhasil');
   }   

   public function hapustemuan(Request $request)
   {
      $temuan = Temuan::findOrFail($request->id_temuan);
      $temuan->delete();
      Rekomendasi::where('id_temuan',$request->id_temuan)->delete();
      return back()->with('success','Hapus Temuan Berhasil');
   }   

   public function inputrekomendasi(Request $request)
   {
      $data = [
         'rekomendasi' => $request->rekomendasi,
         'nilai_rekom' => (float) str_replace(',', '.', str_replace('.', '', preg_replace('/[^\d.,]/', '', $request->nilai_rekom))),
         'id_lhp' => $request->id_lhp,
         'jenis' => $request->jenis_rekom,
         'id_temuan' => $request->id_temuan,
         'id_pd' => implode('|', $request->pd),
      ];
      Rekomendasi::create($data);

      return back()->with('success','Input Rekomendasi Berhasil');
   }  

   public function editrekom(Request $request, $id)
   {
      $data=[
         'rekomendasi' => $request->rekomendasi,
         'nilai_rekom' => (float) str_replace(',', '.', str_replace('.', '', preg_replace('/[^\d.,]/', '', $request->nilai_rekom))),
         'id_lhp' => $request->id_lhp,
         'jenis' => $request->jenis_rekom,
         'id_temuan' => $request->id_temuan,
         'id_pd' => implode('|', $request->pd),
         'ket' => $request->ket,
         'status' => $request->status,
      ];
      $rekom = Rekomendasi::findOrFail($id);
      if($rekom){
         $rekom->update($data);
         return back()->with('success', 'Data Rekomendasi Berhasil di Update');
      }
   }
   
   public function hapusrekom(Request $request)
   {
      $rekom = Rekomendasi::findOrFail($request->id_rekom);
      $pjbrekom = Detail_rekomendasi::where([
         'id_lhp' => $rekom->id_lhp,
         'id_temuan' => $rekom->id_temuan,
         'id_rekom' => $rekom->id,
      ]);
      if ($pjbrekom){
         return back()->with('error','Telah ada tindaklanjut penanggung jawab!!');
      }
      $rekom->delete();
      $pjbrekom->delete();
      return back()->with('success','Hapus Rekomendasi Berhasil');
   }   

   public function bpkdetailrekom($id)
   {
      $rekom = Rekomendasi::findOrFail($id);
      // $rekom = Rekomendasi::with('lhp')->find($id);
      $lhp = Lhp::findOrFail($rekom->id_lhp);
      $temuan = Temuan::findOrFail($rekom->id_temuan);
      $all_pd = Pd::all();
      $pd = collect(explode('|', $rekom->id_pd));
      $fpd = collect($all_pd)->whereIn('kode_pd', $pd)->values();  
      $pjb = Detail_rekomendasi::with('pengembalian')
      ->where([
         'id_rekom' => $rekom->id,
      ])->get();
      // return $rekom;

      return view('admin.bpk.detailrekomendasi', [
         'title' => 'BPK-RI | ' . $lhp->nomor . ' | Detail Rekomendasi',
         'lhp' => $lhp,
         'temuan' => $temuan,
         'rekomendasi' => $rekom,
         'fpd' => $fpd,
         'pjb' => $pjb,
      ]);
   }   

   public function bpkinputpjbrekom(Request $request)
   {
      $data = [
         'id_lhp' => $request->id_lhp,
         'id_temuan' => $request->id_temuan,
         'id_rekom' => $request->id_rekom,
         'id_pd' => $request->pd,
         'pjb' => $request->pjbrekom,
         'ket' => $request->ket,
         'jenis' => $request->jenis_rekom,
         'nilai_rekom' => (float) str_replace(',', '.', str_replace('.', '', preg_replace('/[^\d.,]/', '', $request->nilai_rekom))),
      ];
      Detail_rekomendasi::create($data);

      return back()->with('success','Input Rekomendasi Berhasil');
   }   

   public function bpkhapuspjbrekom(Request $request)
   {
      return $request;
      $pjbrekom = Rekomendasi::findOrFail($request->id_pjbrekom);
      $pjbrekom->delete();
      return back()->with('success','Hapus Rekomendasi Berhasil');
   }   

   public function bpkeditpjbrekom(Request $request)
   {
      $data = [
         'id_pd' => $request->pd,
         'pjb' => $request->pjbrekom,
         'ket' => $request->ket,
         'jenis' => $request->jenis_rekom,
         'status' => $request->status,
         'nilai_rekom' => (float) str_replace(',', '.', str_replace('.', '', preg_replace('/[^\d.,]/', '', $request->nilai_rekom))),
      ];
      $pjb = Detail_rekomendasi::findOrFail($request->id_pjb);
      $pjb->update($data);

      return back()->with('success','Edit Penanggung Jawab Berhasil');
   }   

   public function bpkhapuspjb($id)
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
   public function validasi(Request $request)
   {
      // return $request;
      Tl::where('id_pjb', $request->id_pjb)->update(['siptl' => 0]);
      if (!empty($request->siptl)) {
         Tl::where('id_pjb', $request->id_pjb)
            ->whereIn('id', $request->siptl)
            ->update(['siptl' => 1]);
      }      
      return redirect()->back()->with('success', 'Data Berhasil Divalidasi');

   }

}