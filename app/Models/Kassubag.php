<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kassubag extends Model
{
   use HasFactory;
   protected $fillable = [
      'nama', 'nip', 'jenkel', 'pangkat', 'kode_pd', 'email', 'username'
   ];

}
