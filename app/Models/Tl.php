<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tl extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_rekom','id_pjb','ket','bukti','tgl_sts','tgl_terima_sts','nilai_pengembalian','adm_insp','adm_bpkad','siptl','uploaded'
    ];

    protected $casts = [
        'nilai_pengembalian' => 'decimal:2',
    ];

    public function detailRekomendasi()
    {
        return $this->belongsTo(Detail_rekomendasi::class, 'id_pjb', 'id');
    }

    public function login()
    {
        return $this->belongsTo(Login::class, 'uploaded', 'username');
    }
}