<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pd extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pd','nama_pd','nama_lain'
    ];

    // Satu PD bisa punya banyak login
    public function logins()
    {
        return $this->hasMany(Login::class, 'kode_pd', 'kode_pd');
    }

    public function pd()
    {
        return $this->belongsTo(Detail_rekomendasi::class, 'id_pd', 'kode_pd');
    }
}