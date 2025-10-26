<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_rekomendasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_lhp', 'id_temuan', 'id_rekom', 'id_pd', 'pjb', 'ket', 'jenis', 'rekomendasi', 'nilai_rekom', 'status'
    ];

    protected $casts = [
        'nilai_rekom' => 'decimal:2',
    ];
    
    public function temuan()
    {
        return $this->belongsTo(Temuan::class, 'id_temuan');
    }

    /**
     * Relasi ke LHP
     */
    public function lhp()
    {
        return $this->belongsTo(Lhp::class, 'id_lhp');
    }

    public function rekomendasi()
    {
        return $this->belongsTo(Rekomendasi::class, 'id_rekom');
    }

    public function pengembalian()
    {
        return $this->hasMany(Tl::class, 'id_pjb', 'id');
    }

    public function pd()
    {
        return $this->belongsTo(Pd::class, 'id_pd', 'kode_pd');
    }

}
