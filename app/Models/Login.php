<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Login extends Authenticatable
{
    use Notifiable;

    protected $table = 'logins';

    protected $fillable = [
        'username',
        'password',
        'nama',
        'role',
        'kode_pd',
    ];

    protected $hidden = [
        'password',
    ];

    // Setiap login milik 1 PD
    public function pd()
    {
        return $this->belongsTo(Pd::class, 'kode_pd', 'kode_pd');
    }
    public function pengembalian()
    {
        return $this->hasMany(Tl::class, 'uploaded', 'username');
    }
}