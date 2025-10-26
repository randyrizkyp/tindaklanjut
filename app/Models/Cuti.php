<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $fillable = [
        'nip', 'nama', 'tahun','tanggal', 'jeniscuti', 'jmlhari', 'tglmulai', 'tglselesai', 'alasancuti', 'alamatcuti', 'telepon','masa_kerja','jabatan',
        'atasannip', 'namaatasan','validasiatasan', 'nipkepala', 'namakepala', 'pejabatnip','dokumen', 'dokumenpendukung', 'dokumencuti','status', 'catatan', 'no_surat'
    ];

}
