<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_lhp', 'id_temuan', 'id_pd', 'jenis', 'rekomendasi', 'nilai_rekom', 'status', 'ket'
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

}
