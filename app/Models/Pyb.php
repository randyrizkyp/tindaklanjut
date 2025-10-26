<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pyb extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama', 'pyb_nip'
    ];

}
