<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use App\Models\Pegawai;
use App\Models\Cuti;
use App\Models\Pyb;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index()
    {   
        $t_months = [];
        $b_months = [];
        $s_months = [];
        $m_months = [];
        $p_months = [];

        $tahunan = Cuti::where([
            'status' => 'disetujui',
            'jeniscuti' => 1,
            'tahun' => 2025,
        ])->get(['nip', 'tglmulai', 'tglselesai', 'jeniscuti']);
        // return $tahunan;

        foreach($tahunan as $th){
            $startDate = Carbon::createFromFormat('d/m/Y', $th->tglmulai);
            $endDate = Carbon::createFromFormat('d/m/Y', $th->tglselesai);
            $endDate->modify('first day of next month');
            while ($startDate < $endDate) {
                $t_months[] = $startDate->format('m'); // Format bulan sebagai angka (e.g., 11, 12)
                $startDate->modify('+1 month'); // Tambah 1 bulan
            }
        }
        $countTahunan = array_count_values($t_months);

        $besar = Cuti::where([
            'status' => 'disetujui',
            'jeniscuti' => 2,
            'tahun' => 2025,
        ])->get(['nip', 'tglmulai', 'tglselesai', 'jeniscuti']);

        foreach($besar as $bs){
            $startDate = Carbon::createFromFormat('d/m/Y', $bs->tglmulai);
            $endDate = Carbon::createFromFormat('d/m/Y', $bs->tglselesai);
            $endDate->modify('first day of next month');
            while ($startDate < $endDate) {
                $b_months[] = $startDate->format('m'); // Format bulan sebagai angka (e.g., 11, 12)
                $startDate->modify('+1 month'); // Tambah 1 bulan
            }
        }
        $countBesar = array_count_values($b_months);

        $sakit = Cuti::where([
            'status' => 'disetujui',
            'jeniscuti' => 3,
            'tahun' => 2025,
        ])->get(['nip', 'tglmulai', 'tglselesai', 'jeniscuti']);

        foreach($sakit as $sk){
            $startDate = Carbon::createFromFormat('d/m/Y', $sk->tglmulai);
            $endDate = Carbon::createFromFormat('d/m/Y', $sk->tglselesai);
            $endDate->modify('first day of next month');
            while ($startDate < $endDate) {
                $s_months[] = $startDate->format('m'); // Format bulan sebagai angka (e.g., 11, 12)
                $startDate->modify('+1 month'); // Tambah 1 bulan
            }
        }
        $countSakit = array_count_values($s_months);
       
        $melahirkan = Cuti::where([
            'status' => 'disetujui',
            'jeniscuti' => 4,
            'tahun' => 2025,
        ])->get(['nip', 'tglmulai', 'tglselesai', 'jeniscuti']);

        foreach($melahirkan as $ml){
            $startDate = Carbon::createFromFormat('d/m/Y', $ml->tglmulai);
            $endDate = Carbon::createFromFormat('d/m/Y', $ml->tglselesai);
            $endDate->modify('first day of next month');
            while ($startDate < $endDate) {
                $m_months[] = $startDate->format('m'); // Format bulan sebagai angka (e.g., 11, 12)
                $startDate->modify('+1 month'); // Tambah 1 bulan
            }
        }
        $countMelahirkan = array_count_values($m_months);

        $penting = Cuti::where([
            'status' => 'disetujui',
            'jeniscuti' => 5,
            'tahun' => 2025,
        ])->get(['nip', 'tglmulai', 'tglselesai', 'jeniscuti']);

        foreach($penting as $pt){
            $startDate = Carbon::createFromFormat('d/m/Y', $pt->tglmulai);
            $endDate = Carbon::createFromFormat('d/m/Y', $pt->tglselesai);
            $endDate->modify('first day of next month');
            while ($startDate < $endDate) {
                $p_months[] = $startDate->format('m'); // Format bulan sebagai angka (e.g., 11, 12)
                $startDate->modify('+1 month'); // Tambah 1 bulan
            }
        }
        $countPenting = array_count_values($p_months);

        return response()->json([
            'days' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            'tahunan' => [
                $countTahunan['01'] ?? 0, 
                $countTahunan['02'] ?? 0, 
                $countTahunan['03'] ?? 0, 
                $countTahunan['04'] ?? 0, 
                $countTahunan['05'] ?? 0, 
                $countTahunan['06'] ?? 0, 
                $countTahunan['07'] ?? 0, 
                $countTahunan['08'] ?? 0, 
                $countTahunan['09'] ?? 0, 
                $countTahunan['10'] ?? 0, 
                $countTahunan['11'] ?? 0, 
                $countTahunan['12'] ?? 0, 
            ],
            'besar' => [
                $countBesar['01'] ?? 0, 
                $countBesar['02'] ?? 0, 
                $countBesar['03'] ?? 0, 
                $countBesar['04'] ?? 0, 
                $countBesar['05'] ?? 0, 
                $countBesar['06'] ?? 0, 
                $countBesar['07'] ?? 0, 
                $countBesar['08'] ?? 0, 
                $countBesar['09'] ?? 0, 
                $countBesar['10'] ?? 0, 
                $countBesar['11'] ?? 0, 
                $countBesar['12'] ?? 0, 
            ],
            'sakit' => [
                $countSakit['01'] ?? 0, 
                $countSakit['02'] ?? 0, 
                $countSakit['03'] ?? 0, 
                $countSakit['04'] ?? 0, 
                $countSakit['05'] ?? 0, 
                $countSakit['06'] ?? 0, 
                $countSakit['07'] ?? 0, 
                $countSakit['08'] ?? 0, 
                $countSakit['09'] ?? 0, 
                $countSakit['10'] ?? 0, 
                $countSakit['11'] ?? 0, 
                $countSakit['12'] ?? 0, 
            ],
            'melahirkan' => [
                $countPenting['01'] ?? 0, 
                $countPenting['02'] ?? 0, 
                $countPenting['03'] ?? 0, 
                $countPenting['04'] ?? 0, 
                $countPenting['05'] ?? 0, 
                $countPenting['06'] ?? 0, 
                $countPenting['07'] ?? 0, 
                $countPenting['08'] ?? 0, 
                $countPenting['09'] ?? 0, 
                $countPenting['10'] ?? 0, 
                $countPenting['11'] ?? 0, 
                $countPenting['12'] ?? 0, 
            ],
            'penting' => [
                $countMelahirkan['01'] ?? 0, 
                $countMelahirkan['02'] ?? 0, 
                $countMelahirkan['03'] ?? 0, 
                $countMelahirkan['04'] ?? 0, 
                $countMelahirkan['05'] ?? 0, 
                $countMelahirkan['06'] ?? 0, 
                $countMelahirkan['07'] ?? 0, 
                $countMelahirkan['08'] ?? 0, 
                $countMelahirkan['09'] ?? 0, 
                $countMelahirkan['10'] ?? 0, 
                $countMelahirkan['11'] ?? 0, 
                $countMelahirkan['12'] ?? 0, 
            ],
        ]);      	
    }
}
