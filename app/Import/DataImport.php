<?php

namespace App\Import;

use App\Models\Cuti;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Cuti([
            'id_cuti' => NULL,
            'nip' => $row['nip'],
            'tanggal' => $row['tanggal'],
            'tahun' => $row['tahun'],
            'jeniscuti' => $row['jenis_cuti'],
            'jmlhari' => $row['jumlah_hari'],
            'tglmulai' => $row['tanggal_mulai'],
            'tglselesai' => $row['tanggal_selesai'],
            'alasancuti' => $row['alasan_cuti'],
            'alamatcuti' => $row['alamat_cuti'],
            'telepon' => $row['telepon'],
            'masa_kerja' => $row['masa_kerja'],
            'jabatan' => $row['jabatan'],
            'atasannip' => $row['nip_atasan'],
            'namaatasan' => $row['nama_atasan'],
            'nipkepala' => $row['nip_kadis'],
            'namakepala' => $row['nama_kadis'],
            'pejabatnip' => $row['pyb'],
            'no_surat' => $row['no_surat'],
            'status' => 'disetujui',
            'catatan' => 'imported',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}