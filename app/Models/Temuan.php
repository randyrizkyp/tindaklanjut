<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_lhp', 'temuan'
    ];


    public function lhp()
    {
        return $this->belongsTo(Lhp::class, 'id_lhp');
    }
    
    public function rekomendasi()
    {
        return $this->hasMany(Rekomendasi::class, 'id_temuan');
    }
}
