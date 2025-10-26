<?php

namespace App\Http\Controllers;

use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Models\Cuti;
use App\Models\Pyb;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\IOFactory;


class CetakController extends Controller
{
    public function cetak(Request $request)
    {
        Carbon::setLocale('id');
        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $nip = Session::get('nip');
        $checkmark = html_entity_decode('&#10004;', ENT_COMPAT, 'UTF-8');
        $cuti = Cuti::where(['nip' => $nip, 'status' => 'draft'])->get();
        $jmlhari_thn = Cuti::where(['nip' => $nip, 'status' => 'draft', 'jeniscuti' => '1'])->pluck('jmlhari')->first();
        // return $jmlhari_thn;
        if ($jmlhari_thn){
            $jmlhari = $jmlhari_thn;
        }else{
            $jmlhari = 0;
        }
        $n2 = Cuti::where([
            'nip' => $nip, 
            'tahun' => now()->subYears(2),
            'status' => 'disetujui',
            'jeniscuti' => '1',
            ])->pluck('jmlhari')->sum();
        $n1 = Cuti::where([
            'nip' => $nip, 
            'tahun' => now()->subYears(1),
            'status' => 'disetujui',
            'jeniscuti' => '1',
            ])->pluck('jmlhari')->sum();
        $n = Cuti::where([
            'nip' => $nip, 
            'tahun' => Carbon::now()->year,
            'status' => 'disetujui',
            'jeniscuti' => '1',
            ])->pluck('jmlhari')->sum();
        $en2 = 12 - $n2;
        if ($en2 > 6) {
            $en1 = 6 + (12 - $n1);
            if ($en1 > 6){
                $en = 6 + (12 - $jmlhari);
            }else{
                $en = $en1 + (12 - $jmlhari);
            }
        }else{
            $en1 = $en2 + (12 - $n1);
            if ($en1 > 6){
                $en = 6 + (12 - $jmlhari);
            }else{
                $en = $en1 + (12 - $jmlhari);
            }
        }
        $jeniscuti = $cuti->pluck('jeniscuti')->first();
        $alasancuti = $cuti->pluck('alasancuti')->first();
        $jmlhari = $cuti->pluck('jmlhari')->first();
        $tglmulai = $cuti->pluck('tglmulai')->first();
        $tglselesai = $cuti->pluck('tglselesai')->first();
        $alamatcuti = $cuti->pluck('alamatcuti')->first();
        $masa_kerja = $cuti->pluck('masa_kerja')->first();
        $telepon = $cuti->pluck('telepon')->first();
        $pyb = $cuti->pluck('pejabatnip')->first();
        $pybs = Pyb::where('kd',$pyb)->get();
        $pejabatnama = $pybs->pluck('namapyb')->first();

        //Staf
        if($pyb == 4 || $pyb == 3 || $pyb == 2){
            $client = new Client();
            $atasan = "http://10.90.150.3:5001/api/pegawai/". $cuti->pluck('atasannip')->first();
            $data_a = $client->request('GET', $atasan, [
            'verify'  => false,
            ]);
            $data_atasan = json_decode($data_a->getBody());
            $pegawai = "http://10.90.150.3:5001/api/pegawai/". $nip;
            $data = $client->request('GET', $pegawai, [
            'verify'  => false,
            ]);
            $data_pegawai = json_decode($data->getBody());
            $kadis = "http://10.90.150.3:5001/api/pegawai/". $cuti->pluck('nipkepala')->first();
            $data_c = $client->request('GET', $kadis, [
                'verify'  => false,
            ]);
            $data_kadis = json_decode($data_c->getBody());
            $dt_pyb = "http://10.90.150.3:5001/api/pegawai/". $pybs->pluck('pyb_nip')->first();
                $data_pyb = $client->request('GET', $dt_pyb, [
                'verify'  => false,
            ]);
            $data_pyb = json_decode($data_pyb->getBody());
        
            $nama = $data_pegawai[0]->nama;
            preg_match('/^(.*?)\s*\(/', $data_pegawai[0]->pangkat, $gol_nama);
            preg_match('/^(.*?)\s*\(/', $data_atasan[0]->pangkat, $gol_nama_a);
            preg_match('/^(.*?)\s*\(/', $data_kadis[0]->pangkat, $gol_nama_c);
            preg_match('/^(.*?)\s*\(/', $data_pyb[0]->pangkat, $gol_nama_b);
            $jabatan = $data_pegawai[0]->jabatan;
            $uker = $data_pegawai[0]->unit_kerja;
            $namaatasan = $data_atasan[0]->nama;
            
            // return $jeniscuti;
            // Lokasi template
            if($cuti->pluck('atasannip')->first() == 1){
                $templatePath = storage_path('app/templates/template2.docx');
                $templateProcessor = new TemplateProcessor($templatePath);
                $templateProcessor->setValue('nama_a', '');
                $templateProcessor->setValue('nip_a', '');
                $templateProcessor->setValue('gol_nama_a', '');
            }else{
                $templatePath = storage_path('app/templates/template.docx');
                $templateProcessor = new TemplateProcessor($templatePath);
                $templateProcessor->setValue('nama_a', strtoupper($namaatasan));
                $templateProcessor->setValue('nip_a', $cuti->pluck('atasannip')->first());
                $templateProcessor->setValue('gol_nama_a', $gol_nama_a[1]);
            }
            $nips = 'NIP. ';
            // Ganti placeholder dengan data dinamis
            $templateProcessor->setValue('tanggal', $tanggal);
            $templateProcessor->setValue('nama', strtoupper($nama));
            $templateProcessor->setValue('gol_nama', $gol_nama[1]);
            $templateProcessor->setValue('gol_nama_b', $gol_nama_b[1]);
            $templateProcessor->setValue('gol_nama_c', $gol_nama_c[1]);
            $templateProcessor->setValue('jabatan', ucwords(strtolower($jabatan))); 
            $templateProcessor->setValue('unit_kerja', strtoupper($uker));
            $templateProcessor->setValue('nip', $nip);
            $templateProcessor->setValue('en2', $en2);
            $templateProcessor->setValue('en1', $en1);
            $templateProcessor->setValue('en', $en);
            if ($jeniscuti == 1){
                $templateProcessor->setValue('t', $checkmark);
                $templateProcessor->setValue('b', '');
                $templateProcessor->setValue('s', '');
                $templateProcessor->setValue('m', '');
                $templateProcessor->setValue('p', '');
                $templateProcessor->setValue('n', '');
            }elseif ($jeniscuti == 2) {
                $templateProcessor->setValue('t', '');
                $templateProcessor->setValue('b', $checkmark);
                $templateProcessor->setValue('s', '');
                $templateProcessor->setValue('m', '');
                $templateProcessor->setValue('p', '');
                $templateProcessor->setValue('n', '');
            }elseif($jeniscuti == 3){
                $templateProcessor->setValue('t', '');
                $templateProcessor->setValue('b', '');
                $templateProcessor->setValue('s', $checkmark);
                $templateProcessor->setValue('m', '');
                $templateProcessor->setValue('p', '');
                $templateProcessor->setValue('n', '');
            }elseif ($jeniscuti == 4) {
                $templateProcessor->setValue('t', '');
                $templateProcessor->setValue('b', '');
                $templateProcessor->setValue('s', '');
                $templateProcessor->setValue('m', $checkmark);
                $templateProcessor->setValue('p', '');
                $templateProcessor->setValue('n', '');
            }elseif($jeniscuti == 5){
                $templateProcessor->setValue('t', '');
                $templateProcessor->setValue('b', '');
                $templateProcessor->setValue('s', '');
                $templateProcessor->setValue('m', '');
                $templateProcessor->setValue('p', $checkmark);
                $templateProcessor->setValue('n', '');
            }else{
                $templateProcessor->setValue('t', '');
                $templateProcessor->setValue('b', '');
                $templateProcessor->setValue('s', '');
                $templateProcessor->setValue('m', '');
                $templateProcessor->setValue('p', '');
                $templateProcessor->setValue('n', $checkmark);
            }
            $templateProcessor->setValue('alasan_cuti', $alasancuti);
            $templateProcessor->setValue('hari', $jmlhari);
            $templateProcessor->setValue('tgl_awal', $tglmulai);
            $templateProcessor->setValue('tgl_akhir', $tglselesai);
            $templateProcessor->setValue('alamat', $alamatcuti);
            $templateProcessor->setValue('tlp', $telepon);
            $templateProcessor->setValue('masa_kerja', $masa_kerja);
            $templateProcessor->setValue('nama_b', strtoupper($pejabatnama));
            $templateProcessor->setValue('nips', $nips);
            $templateProcessor->setValue('nip_b', $pybs->pluck('pyb_nip')->first());
            $templateProcessor->setValue('nama_c', strtoupper($cuti->pluck('namakepala')->first()));
            $templateProcessor->setValue('nip_c', $cuti->pluck('nipkepala')->first());

            // Nama file yang akan dihasilkan
            $fileName = 'cuti_' . $nip . '.docx';
            $filePath = storage_path($fileName);

            // Simpan file yang dihasilkan
            $templateProcessor->saveAs($filePath);

            // Kirim file untuk diunduh
            return response()->download($filePath)->deleteFileAfterSend(true);
        }else{
            $client = new Client();
            $atasan = "http://10.90.150.3:5001/api/pegawai/". $cuti->pluck('atasannip')->first();
            $data_a = $client->request('GET', $atasan, [
            'verify'  => false,
            ]);
            $data_atasan = json_decode($data_a->getBody());
            $pegawai = "http://10.90.150.3:5001/api/pegawai/". $nip;
            $data = $client->request('GET', $pegawai, [
            'verify'  => false,
            ]);
            $data_pegawai = json_decode($data->getBody());
            $dt_pyb = Pyb::where('kd',1)->first();
            
            $nama = $data_pegawai[0]->nama;
            preg_match('/^(.*?)\s*\(/', $data_pegawai[0]->pangkat, $gol_nama);
            preg_match('/^(.*?)\s*\(/', $data_atasan[0]->pangkat, $gol_nama_c);
            $jabatan = $data_pegawai[0]->jabatan;
            $uker = $data_pegawai[0]->unit_kerja;
            $namaatasan = $data_atasan[0]->nama;
                        
            $templatePath = storage_path('app/templates/template2.docx');
            $templateProcessor = new TemplateProcessor($templatePath);
            $templateProcessor->setValue('nama_a', '');
            $templateProcessor->setValue('nip_a', '');
            $templateProcessor->setValue('gol_nama_a', '');
            
            $nips = '';
            // Ganti placeholder dengan data dinamis
            $templateProcessor->setValue('tanggal', $tanggal);
            $templateProcessor->setValue('nama', strtoupper($nama));
            $templateProcessor->setValue('gol_nama', $gol_nama[1]);
            $templateProcessor->setValue('gol_nama_b', '');
            $templateProcessor->setValue('gol_nama_c', $gol_nama_c[1]);
            $templateProcessor->setValue('jabatan', ucwords(strtolower($jabatan))); 
            $templateProcessor->setValue('unit_kerja', strtoupper($uker));
            $templateProcessor->setValue('nip', $nip);
            $templateProcessor->setValue('en2', $en2);
            $templateProcessor->setValue('en1', $en1);
            $templateProcessor->setValue('en', $en);
            if ($jeniscuti == 1){
                $templateProcessor->setValue('t', $checkmark);
                $templateProcessor->setValue('b', '');
                $templateProcessor->setValue('s', '');
                $templateProcessor->setValue('m', '');
                $templateProcessor->setValue('p', '');
                $templateProcessor->setValue('n', '');
            }elseif ($jeniscuti == 2) {
                $templateProcessor->setValue('t', '');
                $templateProcessor->setValue('b', $checkmark);
                $templateProcessor->setValue('s', '');
                $templateProcessor->setValue('m', '');
                $templateProcessor->setValue('p', '');
                $templateProcessor->setValue('n', '');
            }elseif($jeniscuti == 3){
                $templateProcessor->setValue('t', '');
                $templateProcessor->setValue('b', '');
                $templateProcessor->setValue('s', $checkmark);
                $templateProcessor->setValue('m', '');
                $templateProcessor->setValue('p', '');
                $templateProcessor->setValue('n', '');
            }elseif ($jeniscuti == 4) {
                $templateProcessor->setValue('t', '');
                $templateProcessor->setValue('b', '');
                $templateProcessor->setValue('s', '');
                $templateProcessor->setValue('m', $checkmark);
                $templateProcessor->setValue('p', '');
                $templateProcessor->setValue('n', '');
            }elseif($jeniscuti == 5){
                $templateProcessor->setValue('t', '');
                $templateProcessor->setValue('b', '');
                $templateProcessor->setValue('s', '');
                $templateProcessor->setValue('m', '');
                $templateProcessor->setValue('p', $checkmark);
                $templateProcessor->setValue('n', '');
            }else{
                $templateProcessor->setValue('t', '');
                $templateProcessor->setValue('b', '');
                $templateProcessor->setValue('s', '');
                $templateProcessor->setValue('m', '');
                $templateProcessor->setValue('p', '');
                $templateProcessor->setValue('n', $checkmark);
            }
            $templateProcessor->setValue('alasan_cuti', $alasancuti);
            $templateProcessor->setValue('hari', $jmlhari);
            $templateProcessor->setValue('tgl_awal', $tglmulai);
            $templateProcessor->setValue('tgl_akhir', $tglselesai);
            $templateProcessor->setValue('alamat', $alamatcuti);
            $templateProcessor->setValue('tlp', $telepon);
            $templateProcessor->setValue('masa_kerja', $masa_kerja);
            $templateProcessor->setValue('nama_b', '');
            $templateProcessor->setValue('nips', $nips);
            $templateProcessor->setValue('nip_b', strtoupper($pejabatnama));
            $templateProcessor->setValue('nama_c', strtoupper($cuti->pluck('namaatasan')->first()));
            $templateProcessor->setValue('nip_c', $cuti->pluck('atasannip')->first());

            // Nama file yang akan dihasilkan
            $fileName = 'cuti_' . $nip . '.docx';
            $filePath = storage_path($fileName);

            // Simpan file yang dihasilkan
            $templateProcessor->saveAs($filePath);

            // Kirim file untuk diunduh
            return response()->download($filePath)->deleteFileAfterSend(true);
        }
    }

    public function downloadword($id)
   {
      $cuti = Cuti::where('id_cuti', $id);
      if($cuti->pluck('jeniscuti')->first() == '1'){
         $jenis_cuti = 'Cuti Tahunan';
      }elseif ($cuti->pluck('jeniscuti')->first() == '2'){
         $jenis_cuti = 'Cuti Besar';
      }elseif ($cuti->pluck('jeniscuti')->first() == '3'){
         $jenis_cuti = 'Cuti Sakit';
      }elseif ($cuti->pluck('jeniscuti')->first() == '4'){
         $jenis_cuti = 'Cuti Melahirkan';
      }elseif ($cuti->pluck('jeniscuti')->first() == '5'){
         $jenis_cuti = 'Cuti Karena Alasan Penting';
      }else{
         $jenis_cuti = 'Cuti di Luar Tanggungan Negara';
      }
      
      $client = new Client();
      $pegawai = "http://10.90.150.3:5001/api/pegawai/". $cuti->pluck('nip')->first();
      $dapeg = $client->request('GET', $pegawai, [
      'verify'  => false,
      ]);
      $data_pegawai = json_decode($dapeg->getBody());
      // return $data_pegawai[0];
      // return $cuti->first();

      Carbon::setLocale('id');
      if($cuti->pluck('jabatan')->first() == '4'){
         $templatePath = storage_path('app/templates/cuti2.docx');
      }elseif ($cuti->pluck('jabatan')->first() == '2' || $cuti->pluck('jabatan')->first() == '3'){
         $templatePath = storage_path('app/templates/cutisekda.docx');
      }else{
         $templatePath = storage_path('app/templates/cutigaruda.docx');
      }
      if ($cuti->pluck('jeniscuti')->first() == '1'){
         $kalender = 'Kerja';
      }else{
         $kalender = 'Kelender';
      }
      $templateProcessor = new TemplateProcessor($templatePath);
      $templateProcessor->setValue('jenis_cuti', $jenis_cuti);
      $templateProcessor->setValue('tahun', $cuti->pluck('tahun')->first());
      $templateProcessor->setValue('nama', $data_pegawai[0]->nama);
      $templateProcessor->setValue('nip', $cuti->pluck('nip')->first());
      $templateProcessor->setValue('pangkat', $data_pegawai[0]->pangkat);
      $templateProcessor->setValue('jabatan', $data_pegawai[0]->jenis_jbt);
      $templateProcessor->setValue('unit_kerja', $data_pegawai[0]->unit_kerja);
      $templateProcessor->setValue('jmlhari', $cuti->pluck('jmlhari')->first());
      $templateProcessor->setValue('tglmulai', Carbon::createFromFormat('d/m/Y', $cuti->pluck('tglmulai')->first())->translatedFormat('d F Y'));
      $templateProcessor->setValue('tglselesai', Carbon::createFromFormat('d/m/Y', $cuti->pluck('tglselesai')->first())->translatedFormat('d F Y'));
      $templateProcessor->setValue('alamatcuti', $cuti->pluck('alamatcuti')->first());
      $templateProcessor->setValue('tgl', Carbon::now()->translatedFormat('d F Y'));
      $templateProcessor->setValue('kal', $kalender);
      $templateProcessor->setValue('no_surat', $cuti->pluck('no_surat')->first());

      $fileName = 'dokumencuti_' . $cuti->pluck('nip') . '.docx';
      $filePath = storage_path($fileName);

        // Simpan file yang dihasilkan
      $templateProcessor->saveAs($filePath);
      return response()->download($filePath)->deleteFileAfterSend(true);
      

   }

}
